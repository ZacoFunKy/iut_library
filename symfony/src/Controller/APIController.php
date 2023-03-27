<?php

namespace App\Controller;

use App\Entity\Lecteur;
use App\Repository\LecteurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use App\Entity\Livre;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use FOS\RestBundle\Controller\Annotations\View;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/register', name: 'api_reg', methods: ['POST'])]
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
            'user' => [
                'id' => $lecteur->getId(),
                'email' => $lecteur->getEmail(),
                'mdp' => $lecteur->getPassword(),
                'prenom' => $lecteur->getPrenomLecteur(),
                'nom' => $lecteur->getNomLecteur(),
            ]
        ];
        return new JsonResponse($response);
    }

    #[Route('/login', name: 'api_login', methods: ['POST'])]
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
            'user' => [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'mdp' => $user->getPassword(),
                'token' => $token,
            ]
        ];
        return new JsonResponse($response);
    }

    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/api/books', name: 'app_api_books')]
    public function books(EntityManagerInterface $entityManager) : Response
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

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $this->json($livres, 200, [], ['groups' => 'livre_basic']);
    }

   

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
            return $this->json(['message' => 'No books found'], 404);
        }

        return $emprunts;
    }

    #[View(serializerGroups: ['livre_basic'])]
    #[Route('/books/research/', name: 'app_api_research', methods: ['GET'])]
    public function research(EntityManagerInterface $entityManager)
    {
        $name = $_GET['name'];
        if($name == null){
            return $this->json(['message' => 'No books found'], 404);
        }
        $livres_titre = "SELECT l FROM App\Entity\Livre l WHERE l.titre LIKE :name";
        $livres_titre = $entityManager->createQuery($livres_titre)->setParameter('name', $name . '%')->getResult();
        if($livres_titre == null){
            $livres_titre = [];
        }
        $author = "SELECT a FROM App\Entity\Auteur a WHERE a.intituleAuteur LIKE :name";
        $author = $entityManager->createQuery($author)->setParameter('name', $name . '%')->getResult();
        if($author == null){
            $livre_author = [];
        }else{
            $i = 0;
            $livre_author = [];
            foreach ($author as $a) {
                foreach ($a->getLivres() as $l) {
                    $livre_author[$i] = $l;
                    $i++;
                }
            }
        }
        $livres = array_unique(array_merge($livres_titre,$livre_author), SORT_REGULAR);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $livres;
    }
}
