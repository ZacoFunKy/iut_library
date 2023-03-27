<?php

namespace App\Controller;

use App\Entity\Lecteur;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/register', name: 'api_reg', methods: ['POST'])]
    public function register(
        EntityManagerInterface $em,
        Request $request,
        ValidatorInterface $v,
        UserPasswordHasherInterface $uPH,
        SerializerInterface $serializer
    )
        {
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
}
