<?php

namespace App\Controller;

use App\Entity\Emprunt;
use App\Entity\Lecteur;
use App\Entity\Categorie;
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
        if ($user === null) {
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
        if (null === $token) {
            return $this->json([
                'message' => 'Pas de lecteur avec ce token',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        $emprunts = array();
        $emprunts = $lecteur->get4DerniersEmprunts();

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json($emprunts, 200, [], ['groups' => ['emprunt_basic', 'livre_basic']])->setMaxAge(3600);
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

        // recupere les emprunt du lecteur
        $emprunts = $lecteur->get4DerniersEmprunts();

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json($emprunts, 200, [], ['groups' => ['emprunt_basic', 'livre_basic']])->setMaxAge(3600);
    }

    // route qui renvoie les amis d'un lecteur
    #[Route('/amis', name: 'api_amis', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/amis",
     * tags={"amis"},
     * summary="amis d'un lecteur",
     * description="Donne les amis d'un lecteur en fonction de son email",
     * operationId="amis",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"email"},
     *  @OA\Property(property="email", type="string", example="
     * "),
     * )
     * ),
     * @OA\Response(
     *  response=201,
     * description="Les amis de l'utilisateur",
     * @OA\MediaType(
     *    mediaType="application/json",
     *   @OA\Schema(
     *    type="array",
     *   @OA\Items(
     *   type="integer",
     *  example={805, 701, 632}
     * )
     * )
     * ),
     * ),
     * @OA\Response(
     * response=401,
     * description="L'email n'appartient a personne",
     * @OA\JsonContent(
     * @OA\Property(property="message  ", type="string",example="Pas de lecteur avec cet email"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['ami_basic'])]
    public function amisLecteur(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $email = $data['email'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $email]);
        if ($lecteur === null) {
            return $this->json([
                'message' => 'Pas de lecteur avec cet email',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $amis = $lecteur->getLecteursSuivis();
        // limiter le nombre d'emprunt de chaque ami a 3


        if (empty($amis)) {
            return $this->json(['message' => 'No friends found'], 404);
        }

        return $this->json($amis, 200, [ ], ['groups' => 'lecteur_basic'])->setMaxAge(3600);
    }

    // route qui ne permet de ne plus suivre un lecteur
    #[Route('/amis/delete', name: 'api_amis_delete', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/amis/delete",
     * tags={"amis"},
     * summary="supprimer un ami",
     * description="Supprime un ami d'un lecteur en fonction de son email",
     * operationId="amisDelete",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"email", "emailAmi"},
     *  @OA\Property(property="email", type="string", example="
     * "),
     * @OA\Property(property="emailAmi", type="string", example="
     * "),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="L'ami a été supprimé",
     * @OA\JsonContent(
     *  @OA\Property(property="message", type="string", example="L'ami a été supprimé"),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="L'email n'appartient a personne",
     * @OA\JsonContent(
     * @OA\Property(property="message  ", type="string",example="Pas de lecteur avec cet email"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['ami_basic'])]
    public function amisLecteurDelete(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $email = $data['email'];
        $emailAmi = $data['emailAmi'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $email]);
        $lecteurAmi = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $emailAmi]);
        if ($lecteur === null) {
            return $this->json([
                'message' => 'Pas de lecteur avec cet email',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $lecteur->removeLecteursSuivi($lecteurAmi);
        $entityManager->persist($lecteur);
        $entityManager->flush();

        return $this->json(['message' => 'L\'ami a été supprimé'], 201);
    }


    // route qui permet de suivre un lecteur
    #[Route('/amis/add', name: 'api_amis_add', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/amis/add",
     * tags={"amis"},
     * summary="ajouter un ami",
     * description="Ajoute un ami d'un lecteur en fonction de son email",
     * operationId="amisAdd",
     * @OA\RequestBody(
     *   required=true,
     *  @OA\JsonContent(
     *   required={"email", "emailAmi"},
     *  @OA\Property(property="email", type="string", example="
     * "),
     * @OA\Property(property="emailAmi", type="string", example="
     * "),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="L'ami a été ajouté",
     * @OA\JsonContent(
     *  @OA\Property(property="message", type="string", example="L'ami a été ajouté"),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="L'email n'appartient a personne",
     * @OA\JsonContent(
     * @OA\Property(property="message  ", type="string",example="Pas de lecteur avec cet email"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['ami_basic'])]
    public function amisLecteurAdd(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $email = $data['email'];
        $emailAmi = $data['emailAmi'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $email]);
        $lecteurAmi = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $emailAmi]);
        if ($lecteur === null) {
            return $this->json([
                'message' => 'Pas de lecteur avec cet email',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $lecteur->addLecteursSuivi($lecteurAmi);
        $entityManager->persist($lecteur);
        $entityManager->flush();

        return $this->json(['message' => 'L\'ami a été ajouté'], 201);
    }


    /**
     * Renvoi les 4 dernières acquisitions de la bibliothèque
     */
    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/api/books', name: 'app_api_books')]
    public function books(EntityManagerInterface $entityManager): Response
    {
        $livres = $entityManager->getRepository(Livre::class)->findBy([], [], 10);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json($livres, 200, [], ['groups' => 'livre_basic']);
    }

    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/last_posts', name: 'app_api_last_posts')]
    public function lastPosts(EntityManagerInterface $entityManager)
    {
        $livres = $entityManager->getRepository(Livre::class)->findBy([], ['dateAcquisition' => 'DESC'], 4);
        $livres = array_slice($livres, 0, 4);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json($livres, 200, [], ['groups' => 'livre_basic'])->setMaxAge(3600);
    }


    /**
     * Renvoi la liste des 4 derniers emprunts du lecteur
     */
    /*
    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/last_emprunts', name: 'app_api_last_emprunts', methods: ['POST'])]
    public function lastEmprunts(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $token = $data['token'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $lecteur) {
            return $this->json([
                'message' => 'missing credentials',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $emprunts = $lecteur->getEmprunts();
        $emprunts = array_slice($emprunts->toArray(), 0, 4);

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404)->setMaxAge(3600);
        }

        return $emprunts;
    }*/
    /**
     * Recherche de livre en fonction du nom de l'auteur
     */
    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/research/', name: 'app_api_research', methods: ['GET'])]
    public function research(EntityManagerInterface $entityManager)
    {
        $name = $_GET['name'];
        $max = $_GET['maxResults'];
        $startIndex = $_GET['startIndex'];

        $author = "SELECT a FROM App\Entity\Auteur a WHERE a.intituleAuteur LIKE :name";
        // recuperer tous les livres ecris par un auteur dont le nom ressembe a $name en sql
        $author = $entityManager->createQuery($author)->setParameter('name', $name . '%')->getResult();

        $livres = [];
        foreach ($author as $auteur) {
            $livres = array_merge($livres, $auteur->getLivres()->toArray());
        }
        $nbResults = 0;
        foreach ($livres as $livre) {
            $nbResults++;
        }
 
        $livres = array_slice($livres, $startIndex, $max);

        if ($livres == null) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json(['livres' => $livres, 'nbResults' => $nbResults], 200, [], ['groups' => 'livre_basic']);
    }

    // route qui retourne les auteurs qui correspondent au nom passé en paramètre
    #[Route('/authors/research/', name: 'app_api_research_author', methods: ['GET'])]
    public function researchAuthor(EntityManagerInterface $entityManager)
    {
        $name = $_GET['name'];
        $maxResults = $_GET['maxResults'];

        if ($name == null) {
            return $this->json(['message' => 'No authors found'], 404);
        }
        $authors = "SELECT a FROM App\Entity\Auteur a WHERE a.intituleAuteur LIKE :name";
        // limiter le nb de resuts a 10
        $authors = $entityManager->createQuery($authors)->setParameter('name', $name . '%')->setMaxResults($maxResults)->getResult();
        if ($authors == null) {
            return $this->json(['message' => 'No authors found'], 404);
        }

        return $this->json($authors, 200, [], ['groups' => 'auteur_basic'])->setMaxAge(3600);
    }



    
    #[Route('/recommandation', name: 'app_api_recommandation', methods: ['POST'])]
    public function recommandation(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $token = $data['token'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $lecteur) {
            return $this->json([
                'message' => 'Pas de lecteur avec ce token',
            ], Response::HTTP_UNAUTHORIZED);
        }
        $personnes = array();
        var_dump(sizeof($lecteur->getLecteursSuivis()));
        $q = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e')
            ->where('e.lecteur = :lecteur')
            ->setParameter('lecteur', $lecteur)
            ->getQuery()
            ->getResult();
        $listLivre = array();
        foreach ($q as $myE) {
            array_push($listLivre, $myE->getLivre());
        }
        $q2 = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e')
            ->where('e.livre IN (:list)')
            ->setParameter('list', $listLivre)
            ->groupBy('e.lecteur')
            ->orderBy("Count('e.livre')", "DESC")
            ->getQuery()
            ->getResult();
        var_dump("ici");
        var_dump(sizeof($q2));
        foreach ($q2 as $t) {
            var_dump($t->getLecteur()->getNomlecteur());
        }
        var_dump(sizeof($q));
        foreach ($q as $emp) {
            array_push($personnes, $emp->getId());
        }
        //$emprunts = array_slice($emprunts, 0, 4);

        if (empty($emprunts)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $emprunts;
    }
    
}
