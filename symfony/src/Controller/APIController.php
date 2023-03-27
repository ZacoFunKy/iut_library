<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Livre;
use FOS\RestBundle\Controller\Annotations\View;

#[Route('/api')]
class APIController extends AbstractController
{
    #[Route('/a/p/i', name: 'app_a_p_i')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'APIController',
        ]);
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
    #[Route('/books/last_emprunts', name: 'app_api_last_emprunts')]
    public function lastEmprunts(EntityManagerInterface $entityManager)
    {
        $livres = $entityManager->getRepository(Livre::class)->findBy(['lecteur' => $lecteur], ['dateEmprunt' => 'DESC'], 4);

        if (empty($livres)) {
            return $this->json(['message' => 'No books found'], 404);
        }

        return $livres;
    }
}
