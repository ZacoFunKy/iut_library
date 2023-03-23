<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Livre;
use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Genre;
use App\Entity\Langue;


class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // By using Google Books API get 200 random books and add them to the database
        for($i = 0; $i < 200; $i=$i+40) {
            $base_url= "https://www.googleapis.com/books/v1/volumes?q=inauthor&maxResults=40&startIndex=$i";
            $json = file_get_contents($base_url);
            $data = json_decode($json, true);
            $results = $data['items'];
            foreach($results as $results) {
                $livre = new Livre();
                $livre->setTitre($results['volumeInfo']['title']);
                if(!isset($results['volumeInfo']['description'])) {
                    $livre->setDescription("No description available");
                } else {
                    $livre->setDescription($results['volumeInfo']['description']);
                }
                $dateParuption = $results['volumeInfo']['publishedDate'];
                $dateParuption = new \DateTime($dateParuption);
                $livre->setDateparution($dateParuption);
                $livre->setPage($results['volumeInfo']['pageCount']);
                $livre->setCouverture($results['volumeInfo']['imageLinks']['thumbnail']);
                if(!isset($results['volumeInfo']['publisher'])) {
                } else {
                    $editor = $results['volumeInfo']['publisher'];
                    $editeur = $manager->getRepository(Editeur::class)->findOneBy(['nomediteur' => $editor]);
                    if($editeur == null) {
                        $editeur = new Editeur();
                        $editeur->setNomediteur($editor);
                        $manager->persist($editeur);
                    }
                    $livre->setIdEditeur($editeur);
                }
                if(!isset($results['volumeInfo']['categories'])){
                } else {
                    $categoris = $results['volumeInfo']['categories'];
                }
                foreach($categoris as $categoris) {
                    $genre = $manager->getRepository(Categorie::class)->findOneBy(['nomgenre' => $categoris]);
                    if($genre == null) {
                        $genre = new Categorie();
                        $genre->setNomcategorie($categoris);
                        $manager->persist($genre);
                    }
                    $livre->addNomcategorie($genre);
                }
                $langue = $results['volumeInfo']['language'];
                $langue = $manager->getRepository(Langue::class)->findOneBy(['nomlangue' => $langue]);
                if($langue == null) {
                    $langage = new Langue();
                    $langage->setNomlangue($langue);
                    $manager->persist($langue);
                }
                $manager->persist($livre);
            }
        }

        $manager->flush();

    }
}
