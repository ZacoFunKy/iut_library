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
     * tags={"Lecteur"},
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
     * tags={"Lecteur"},
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
     * tags={"Lecteur"},
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
     * tags={"Lecteur"},
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
     *  @OA\Property(property="message ", type="string",example="Pas de lecteur avec cet email"),
     * )
     * )
     * )
     */
    #[View(serializerGroups: ['livre_basic'])]
    public function empruntLecteur(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        $email = $data['email'];
        $lecteur = $entityManager->getRepository(Lecteur::class)->findOneBy(['email' => $email]);
        if (null === $lecteur) {
            return $this->json(
                [
                    'message' => 'Pas de lecteur avec cet email',
                ],
                Response::HTTP_UNAUTHORIZED
            );
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
    #[Route('/books/last_posts', name: 'app_api_last_posts', methods: ['GET'])]
    /**
     * @OA\Get(
     * path="/api/books/last_posts",
     * tags={"Livre"},
     * summary="dernier livres ajoutés",
     * description="Donne les dernier livres ajoutés",
     * operationId="last_posts",
     * @OA\Response(
     *  response=200,
     * description="Les livres",
     * @OA\MediaType(
     *    mediaType="application/json",
     * ),
     * ),
     * @OA\Response(
     * response=404,
     * description="Pas de livres",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="No books found"),
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Erreur de requête",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bad request"),
     * )
     * )
     * )
     * )
     */
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
    #[Route('/books/research', name: 'app_api_research', methods: ['GET'])]
    /**
     * @OA\Get(
     * path="/api/books/research",
     * tags={"Livre"},
     * summary="Recherche de livre",
     * description="Recherche de livre en fonction du titre de l'oeuvre et du nom de l'auteur",
     * operationId="research",
     * @OA\Parameter(
     * name="name",
     * in="query",
     * description="Nom du livre ou de l'auteur",
     * required=true,
     * @OA\Schema(
     * type="string",
     * example="Harry Potter"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Les livres",
     * @OA\MediaType(
     *   mediaType="application/json",
     * ),
     * ),
     * @OA\Response(
     *  response=404,
     * description="Pas de livres",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="No books found"),
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Erreur de requête",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bad request"),
     * )
     * )
     * )
     * )
     */
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
        $author = "SELECT a FROM App\Entity\Auteur a WHERE a.intituleAuteur LIKE :name";
        $author = $entityManager->createQuery($author)->setParameter('name', $name . '%')->getOneOrNullResult();
        if ($author == null) {
            $livre_author = [];
        } else {
            $livre_author = $author->getLivres();
        }
        $livres = array_unique(array_merge($livres_titre, $livre_author), SORT_REGULAR);
        $livres[] = ['TotalResponse' => count($livres)];

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }
        return $livres;
    }

    #[Route('/books/{id}', name: 'app_api_book', methods: ['GET'])]
    /**
     * @OA\Get(
     * path="/api/books/{id}",
     * tags={"Livre"},
     * summary="Renvoi un livre",
     * description="Renvoi un livre en fonction de son id",
     *  operationId="book",
     * @OA\Parameter(
     * name="id",
     * in="path",
     * description="id du livre",
     *  required=true,
     * @OA\Schema(
     * type="integer",
     * example="1"
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Le livre",
     * @OA\MediaType(
     *  mediaType="application/json",
     * ),
     * ),
     * @OA\Response(
     * response=404,
     * description="Pas de livres",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="No books found"),
     * )
     * ),
     * @OA\Response(
     * response=400,
     * description="Erreur de requête",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Bad request"),
     * )
     * )
     * )
     * )
     */
    public function book(EntityManagerInterface $entityManager, $id, SerializerInterface $serializer)
    {
        $livre = $entityManager->getRepository(Livre::class)->find($id);
        if (null === $livre) {
            return $this->json(['message' => 'No books found'], 404);
        }
        $json = $serializer->serialize($livre, 'json', ['groups' => 'livre_basic']);
        return new JsonResponse($json, 200, [], true);
    }


    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/friends', name: 'app_api_return', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/friends",
     * tags={"Friends"},
     * summary="Renvoi la liste des amis",
     * description="Renvoi la liste des amis d'un utilisateur",
     * operationId="return",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="token",   type="string", example="fzsef"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="La liste des amis",
     * @OA\MediaType(
     * mediaType="application/json",
     * ),
     * ),
     * @OA\Response(
     * response=404,
     * description="Pas d'amis",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="You don't have any friends"),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Erreur de requête",
     * @OA\JsonContent(
     *
     * @OA\Property(property="message", type="string", example="missing credentials"),
     * )
     * )
     * )
     * )
     */
    public function listfriends(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        if (!isset($data['token'])) {
            return $this->json(
                [
                    'message' => 'missing credentials',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $data['token'];
        $user = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $user) {
            return $this->json(
                [
                    'message' => 'No user found',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $friends = $user->getLecteursQuiMeSuivent();
        if (empty($friends)) {
            return new JsonResponse(["message" => "You don't have any friends"]);
        }
        $response = [];
        foreach ($friends as $friend) {
            $emprunts = [];
            foreach ($friend->getEmprunts() as $emprunt) {
                $author = [];
                foreach ($emprunt->getLivre()->getAuteurs() as $auteur) {
                    $author[] = $auteur->getIntituleAuteur();
                }
                $emprunts[] = [
                    'id' => $emprunt->getId(),
                    'dateEmprunt' => $emprunt->getDateEmprunt(),
                    'titre' => $emprunt->getLivre()->getTitre(),
                    'description' => $emprunt->getLivre()->getDescription(),
                    'auteur' => $author,
                    'dateAcquisition' => $emprunt->getLivre()->getDateAcquisition(),
                ];
            }
            $response[] = [
                'email' => $friend->getEmail(),
                'prenom' => $friend->getPrenomLecteur(),
                'nom' => $friend->getNomLecteur(),
                'photoProfil' => $friend->getImagedeprofil(),
                'TotalEmprunts' => count($friend->getEmprunts()),
                'empreunts' => $emprunts
            ];
        }

        return new JsonResponse($response);
    }


    #[Route('/add_friend', name: 'app_api_add_friend', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/add_friend",
     * tags={"Friends"},
     * summary="Ajoute un ami",
     * description="Ajoute un ami à un utilisateur",
     * operationId="add_friend",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="token",     type="string", example="fzsef"),
     * @OA\Property(property="id_freind", type="integer", example="605"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="L'ami a été ajouté",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="Friend added"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Pas d'amis",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="Your freind is not in the database"),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Erreur de requête",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="missing credentials"),
     * )
     * )
     * )
     * )
     */
    public function addfriend(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        if (!isset($data['token'])) {
            return $this->json(
                [
                    'message' => 'missing credentials',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $data['token'];
        $user = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $user) {
            return $this->json(
                [
                    'message' => 'No user found',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $friend = $entityManager->getRepository(Lecteur::class)->findOneBy(['id' => $data['id_freind']]);
        if (null === $friend) {
            return $this->json(
                [
                    'message' => 'Your freind is not in the database',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $user->addLecteursSuivi($friend);
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(["message" => "Friend added"]);
    }

    #[Route('/delete_friend', name: 'app_api_delete_friend', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/delete_friend",
     * tags={"Friends"},
     * summary="Supprime un ami",
     * description="Supprime un ami à un utilisateur",
     * operationId="delete_friend",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="token",     type="string", example="fzsef"),
     * @OA\Property(property="id_freind", type="integer", example="605"),
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="L'ami a été supprimé",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="Friend deleted"),
     * )
     * ),
     * @OA\Response(
     * response=404,
     * description="Pas d'amis",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="Your freind is not in the database"),
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Erreur de requête",
     * @OA\JsonContent(
     * @OA\Property(property="message",   type="string", example="missing credentials"),
     * )
     * )
     * )
     * )
     */
    public function deletefriend(EntityManagerInterface $entityManager, Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        if (!isset($data['token'])) {
            return $this->json(
                [
                    'message' => 'missing credentials',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $token = $data['token'];
        $user = $entityManager->getRepository(Lecteur::class)->findOneBy(['token' => $token]);
        if (null === $user) {
            return $this->json(
                [
                    'message' => 'No user found',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $friend = $entityManager->getRepository(Lecteur::class)->findOneBy(['id' => $data['id_freind']]);
        if (null === $friend) {
            return $this->json(
                [
                    'message' => 'Your freind is not in the database',
                ],
                Response::HTTP_UNAUTHORIZED
            );
        }
        $friends = $user->getLecteursQuiMeSuivent();
        if (empty($friends)) {
            return new JsonResponse(["message" => "You don't have any friends"]);
        }
        $response = [];
        foreach ($friends as $friend) {
            $response[] = $friend->getId();
        }
        if (!in_array($data['id_freind'], $response)) {
            return new JsonResponse(["message" => "You don't have this friend"]);
        }
        $user->removeLecteursSuivi($friend);
        $entityManager->persist($user);
        $entityManager->flush();
        return new JsonResponse(["message" => "Friend deleted"]);
    }

    #[View(serializerGroups: ['lecteur_basic'])]
    #[Route('/recommandation', name: 'app_api_recommandation', methods: ['POST'])]
    /**
     * @OA\Post(
     * path="/api/recommandation",
     * tags={"Lecteur"},
     * summary="Recommandation d'utilisateur en fonction de ses emprunts",
     * description="Donne les recommandation d'utilisateur en fonction de ses emprunts",
     * operationId="recommandation",
     * @OA\RequestBody(
     *  required=true,
     * @OA\JsonContent(
     * required={"token"},
     * @OA\Property(property="token", type="string", example="token"),
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Les recommandations de l'utilisateur",
     * @OA\MediaType(
     * mediaType="application/json",
     * @OA\Schema(
     * type="array",
     * @OA\Items(
     * type="integer",
     * example={805, 701, 632}
     * )
     * )
     * ),
     * ),
     * @OA\Response(
     *  response=401,
     *  description="L'email n'appartient a personne",
     * @OA\JsonContent(
     * @OA\Property(property="message  ", type="string",example="Pas de lecteur avec ce token"),
     * )
     * )
     * )
     * )
     * 
     */
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
        $q = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e')
            ->where('e.lecteur = :lecteur')
            ->setParameter('lecteur', $lecteur)
            ->getQuery()
            ->getResult();
        $listLivre = array();
        foreach ($q as $myE) {
            array_push($listLivre, $myE->getLivre());
        }
        if (count($lecteur->getLecteursSuivis()) > 0) {
            $q3 = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e2')
                ->where('e2.livre IN (:list)')
                ->setParameter('list', $listLivre)
                ->andwhere('e2.lecteur != :lecteur')
                ->setParameter('lecteur', $lecteur)
                ->andwhere('e2.lecteur NOT IN (:listLec)')
                ->setParameter('listLec', $lecteur->getLecteursSuivis())
                ->groupBy('e2.lecteur')
                ->orderBy("Count('e.livre')", "DESC")
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
        } else {
            $q3 = $entityManager->getRepository(Emprunt::class)->createQueryBuilder('e2')
                ->where('e2.livre IN (:list)')
                ->setParameter('list', $listLivre)
                ->andwhere('e2.lecteur != :lecteur')
                ->setParameter('lecteur', $lecteur)
                ->groupBy('e2.lecteur')
                ->orderBy("Count('e.livre')", "DESC")
                ->setMaxResults(4)
                ->getQuery()
                ->getResult();
        }
        $result = array();
        foreach ($q3 as $t) {
            array_push($result, $t->getLecteur()->getId());
        }

        if (empty($result)) {
            var_dump("tertqsgqfgqsdf");
            $q2 = $entityManager->getRepository(Lecteur::class)->createQueryBuilder('l')
                ->select('l.id')
                ->andwhere('l != :lecteur')
                ->setParameter('lecteur', $lecteur)
                ->andwhere(':lecteur NOT MEMBER OF l.lecteursQuiMeSuivent')
                ->setParameter('lecteur', $lecteur)
                ->getQuery()
                ->getScalarResult();
            $result = array();
            while (count($result) < 4) {
                $rand = rand(0, count($q2) - 1);
                if (!in_array($q2[$rand], $result)) {
                    array_push($result, $q2[$rand]);
                }
            }
            return $result;
        }
        return $result;
    }
}
