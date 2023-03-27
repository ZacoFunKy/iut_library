<?php

namespace App\DataFixtures;

use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use GuzzleHttp\Client;


class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // get 50 random authors from the api google books using the link : https://www.googleapis.com/books/v1/volumes
        $client = new Client([
            'base_uri' => 'https://www.googleapis.com/books/v1/volumes',
            'verify' => false,
        ]);
        for ($i = 0; $i < 200; $i + 40) {

            $response = $client->request('GET', '?q=inauthor&maxResults=40&startIndex=' . $i);
            $content = $response->getBody()->getContents();
            $content = json_decode($content, true);
            foreach ($content['items'] as $item) {
                $book = new Livre();
                $book->setTitre($item['volumeInfo']['title']);
                $book->setDescription($item['volumeInfo']['description']);
                $book->setDateParution(new \DateTime($item['volumeInfo']['publishedDate']));
                $book->setPage($item['volumeInfo']['pageCount']);
                $book->setCouverture($item['volumeInfo']['imageLinks']['thumbnail']);
                $manager->persist($book);
                $manager->flush();
                $auteur = new Auteur();
                $auteur->setIntituleauteur($item['volumeInfo']['authors'][0]);
                $manager->persist($auteur);
                $manager->flush();
                $categorie = new Categorie();
                $categorie->setNomcategorie($item['volumeInfo']['categories'][0]);
                $manager->persist($categorie);
                $manager->flush();
                $editeur = new Editeur();
                $editeur->setNomediteur($item['volumeInfo']['publisher']);
                $manager->persist($editeur);
                $manager->flush();
            }
        }
    }
}
