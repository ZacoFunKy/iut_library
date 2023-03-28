<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Lecteur;
use App\Repository\LecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Nelmio\ApiDocBundle\Annotation\Security;
use App\Entity\Livre;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use FOS\RestBundle\Controller\Annotations\View;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/register', name: 'api_reg', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/register",
     * tags={"register"},
     * summary="Creer un lecteur",
     * description="Enregistre un nouveau lecteur dans la base de donnée",
     * operationId="enr",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"email", "prenomLecteur","nomLecteur", "password"},
     *  @OA\Property(property="email", type="string", example="mael@gmail.com"),
     *  @OA\Property(property="prenomLecteur", type="string", example="Mael"),
     *  @OA\Property(property="nomLecteur", type="string", example="Jegu"),
     *  @OA\Property(property="password", type="string", example="MonMotDePasse6-")
     * )
     * ),
     * @OA\Response(
     *   response=201,
     *  description="Lecteur créé",
     * @OA\JsonContent(
     *  @OA\Property(property="id", type="string",example="1"),
     *  @OA\Property(property="email", type="string", example="mael@gmail.com"),
     *  @OA\Property(property="password", type="string",
     *  example="$2y$13$zGjD.rUXy78g3Ij9dmoH1.w2uenCrjYKhdEMhGQog.xSenjwH9sWO"),
     *  @OA\Property(property="prenomLecteur", type="string", example="Mael"),
     *  @OA\Property(property="nomLecteur", type="string", example="Jegu"),
     * )
     * ),
     * @OA\Response(
     *   response=401,
     *  description="Les informations données ne sont pas complètes ou non valides",
     * @OA\JsonContent(
     *  @OA\Property(property="error", type="string",
     *  example="There is already an account with this email (code 23bd9dbf-6b9b-41cd-a99e-4844bcf3077f)"),
     * )
     * )
     * )
     */
    public function register(
        EntityManagerInterface $em,
        Request $request,
        ValidatorInterface $v,
        UserPasswordHasherInterface $uPH,
        SerializerInterface $serializer
    ) {
        $json = $request->getContent();
        $lecteur = $serializer->deserialize($json, Lecteur::class, 'json');
        $errors = $v->validate($lecteur);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new Response($errorsString);
        }
        if ($em->getRepository(Lecteur::class)->findBy(['email' => $lecteur->getEmail()]) != null) {
            return new Response("Cette adresse est déjà prise");
        }

        $lecteur->setPassword(
            $uPH->hashPassword(
                $lecteur,
                $lecteur->getPassword()
            )
        );

        $em->persist($lecteur);
        $em->flush();

        $response = [
            'id' => $lecteur->getId(),
            'email' => $lecteur->getEmail(),
            'mdp' => $lecteur->getPassword(),
            'prenom' => $lecteur->getPrenomLecteur(),
            'nom' => $lecteur->getNomLecteur(),
        ];
        return new JsonResponse($response);
    }
    #[Route('/login', name: 'api_login', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/login",
     * tags={"login"},
     * summary="Login un lecteur",
     * description="Se Login avec un utilisateur en lui générant un token",
     * operationId="login",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"username", "password"},
     *  @OA\Property(property="username", type="string", example="mael@gmail.com"),
     *  @OA\Property(property="password", type="string", example="MonMotDePasse6-")
     * )
     * ),
     * @OA\Response(
     *   response=201,
     *  description="Lecteur créé",
     * @OA\JsonContent(
     *  @OA\Property(property="id", type="string",example="1"),
     *  @OA\Property(property="email", type="string", example="mael@gmail.com"),
     *  @OA\Property(property="password", type="string",
     *  example="$2y$13$zGjD.rUXy78g3Ij9dmoH1.w2uenCrjYKhdEMhGQog.xSenjwH9sWO"),
     *  @OA\Property(property="token", type="string", example="6422945aa8c48"),
     * )
     * ),
     * @OA\Response(
     *   response=401,
     *  description="Les informations données ne sont pas complètes ou non valides",
     * @OA\JsonContent(
     *  @OA\Property(property="error", type="string",example="Invalid credentials."),
     * )
     * )
     * )
     */
    public function login(EntityManagerInterface $entityManager, #[CurrentUser] ?Lecteur $user)
    {
        if (null === $user) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $token = uniqid();
        $user->setToken($token);
        $entityManager->persist($user);
        $entityManager->flush();
        $response = [
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'mdp' => $user->getPassword(),
            'token' => $token,
        ];
        return new JsonResponse($response);
    }
    #[IsGranted("ROLE_USER")]
    #[Security(name: "Bearer")]
    #[Route('/lastEmprunt', name: 'api_lastEmprunt', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/lastEmprunt",
     * tags={"lastEmprunt"},
     * summary="dernier emprunt d'un lecteur",
     * description="Donne les dernier emprunt d'un lecteur en fonction de son token",
     * operationId="lastEmprunt",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"token"},
     *  @OA\Property(property="token", type="string", example="060dfszdfs0e95f"),
     * )
     * ),
     * @OA\Response(
     *   response=201,
     *  description="Les emprunts de l'utilisateur",
     * @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(
     *       type="array",
     *       @OA\Items(
     *         type="integer",
     *         example={805, 701, 632}
     *       )
     *     )
     * ),
     * ),
     * @OA\Response(
     *   response=401,
     *  description="Le token n'appartient a personne",
     * @OA\JsonContent(
     *  @OA\Property(property="message  ", type="string",example="Pas de lecteur avec ce token"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['livre_basic'])]
    public function lastEmprunt(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $token = $data['token'];
        var_dump($token);
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $lecteur) {
            return $this->json([
                'message' => 'Pas de lecteur avec ce token',
            ], Response::HTTP_UNAUTHORIZED);
        }
        var_dump($lecteur->getId());
        $emprunts = array();
        $q = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e')
            ->where('e.lecteur = :l')
            ->setParameter('l', $lecteur)
            ->orderBy('e.DateEmprunt', 'DESC')
            ->getQuery()
            ->getResult();
        foreach ($q as $emp) {
            array_push($emprunts, $emp->getLivre()->getId());
        }
        $emprunts = array_slice($emprunts, 0, 4);

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $emprunts;
    }

    #[Route('/emprunt', name: 'api_emprunt', methods: ['POST'])]
   /**
     * @OA\Post(
     * path="/api/emprunt",
     * tags={"emprunt"},
     * summary="dernier emprunt d'un lecteur",
     * description="Donne les dernier emprunt d'un lecteur en fonction de son email",
     * operationId="emprunt",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"email"},
     *  @OA\Property(property="email", type="string", example="maeljegu@gmail.com"),
     * )
     * ),
     * @OA\Response(
     *   response=201,
     *  description="Les emprunts de l'utilisateur",
     * @OA\MediaType(
     *     mediaType="application/json",
     *     @OA\Schema(
     *       type="array",
     *       @OA\Items(
     *         type="integer",
     *         example={805, 701, 632}
     *       )
     *     )
     * ),
     * ),
     * @OA\Response(
     *   response=401,
     *  description="L'email n'appartient a personne",
     * @OA\JsonContent(
     *  @OA\Property(property="message  ", type="string",example="Pas de lecteur avec cet email"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['livre_basic'])]
    public function empruntLecteur(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $id = $data['id'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['id' => $id]);
        if (null === $lecteur) {
            return $this->json([
                'message' => 'Pas de lecteur avec cet id',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $emprunts = array();
        $q = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e')
            ->where('e.lecteur = :l')
            ->setParameter('l', $lecteur)
            ->orderBy('e.DateEmprunt', 'DESC')
            ->getQuery()
            ->getResult();

        foreach ($q as $emp) {
            array_push($emprunts, $emp->getLivre()->getId());
        }
        $emprunts = array_slice($emprunts, 0, 4);

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $emprunts;
    }

    /**
     * Renvoi les 4 dernières acquisitions de la bibliothèque
     */
    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/last_posts', name: 'app_api_last_posts')]
    public function lastPosts(EntityManagerInterface $entityManager)
    {
        $livres = $entityManager->getRepository(Livre::class)->findBy([], ['dateAcquisition' => 'DESC'], 4);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $livres;
    }

    /**
     * Recherche de livre en fonction du titre de l'oeuvre et du nom de l'auteur
     */
    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/research/', name: 'app_api_research', methods: ['GET'])]
    public function research(EntityManagerInterface $entityManager)
    {
        $name = $_GET['name'];
        if ($name == null) {
            return $this->json(['message' => 'No books found'], 404);
        }
        $livres_titre = "SELECT l FROM App\Entity\Livre l WHERE l.titre LIKE :name";
        $livres_titre = $entityManager->createQuery($livres_titre)->setParameter('name', $name . '%')->getResult();
        if ($livres_titre == null) {
            $livres_titre = [];
        }
        $author = "SELECT a FROM App\Entity\Auteur a WHERE a.nom LIKE :name";
        $author = $entityManager->createQuery($author)->setParameter('name', $name . '%')->getOneOrNullResult();
        if ($author == null) {
            $livre_author = [];
        } else {
            $livre_author = $author->getLivres();
        }
        $livres = array_unique(array_merge($livres_titre, $livre_author), SORT_REGULAR);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $livres;
    }
}
