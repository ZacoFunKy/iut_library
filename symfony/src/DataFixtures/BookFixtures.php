<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use App\Entity\Categorie;
use App\Entity\Editeur;
use App\Entity\Langue;
use App\Entity\Livre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class BookFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 200; $i = $i + 40) {
            $baseUrl = "https://www.googleapis.com/books/v1/volumes?q=inauthor&maxResults=40&startIndex=$i";
            $json = file_get_contents($baseUrl);
            $data = json_decode($json, true);
            $results = $data['items'];
            foreach ($results as $results) {
                $livre = new Livre();
                $livre->setTitre($results['volumeInfo']['title']);
                if (!isset($results['volumeInfo']['description'])) {
                    $livre->setDescription("No description available");
                } else {
                    $livre->setDescription($results['volumeInfo']['description']);
                }
                $dateParuption = $results['volumeInfo']['publishedDate'];
                if (is_numeric($dateParuption)) {
                    $dateP = new \DateTime($dateParuption);
                    $livre->setDateparution($dateP);
                }
                if (isset($results['volumeInfo']['pageCount'])) {
                    $livre->setPage($results['volumeInfo']['pageCount']);
                }

                if (isset($results['volumeInfo']['imageLinks']['thumbnail'])) {
                    $livre->setCouverture($results['volumeInfo']['imageLinks']['thumbnail']);
                }
                $aujourdhui = time();
                $avant =  strtotime('-2 years');
                $randomDate = mt_rand($avant, $aujourdhui);
                $dateAcquisition = new \DateTime();
                $dateAcquisition->setTimestamp($randomDate);
                $livre->setDateAcquisition($dateAcquisition);
                if (isset($results['volumeInfo']['publisher'])) {
                    $editor = $results['volumeInfo']['publisher'];
                    $editeur = $manager->getRepository(Editeur::class)->findOneBy(['nomEditeur' => $editor]);
                    if ($editeur == null) {
                        $editeur = new Editeur();
                        $editeur->setNomediteur($editor);
                        $manager->persist($editeur);
                    }
                    $livre->setEditeur($editeur);
                }
                if (isset($results['volumeInfo']['categories'])) {
                    $categoris = $results['volumeInfo']['categories'];
                    foreach ($categoris as $categoris) {
                        $genre = $manager->getRepository(Categorie::class)->findOneBy(['nomCategorie' => $categoris]);
                        if ($genre == null) {
                            $genre = new Categorie();
                            $genre->setNomcategorie($categoris);
                            $manager->persist($genre);
                        }
                        $livre->addCategory($genre);
                    }
                }
                if (isset($results['volumeInfo']['language'])) {
                    $l = $results['volumeInfo']['language'];
                    $langue = $manager->getRepository(Langue::class)->findOneBy(['libelleLangue' => strtolower($l)]);
                    if ($langue == null) {
                        $langue = new Langue();
                        $langue->setLibelleLangue($l);
                        $langue->setNomlangue($l);
                        $manager->persist($langue);
                    }
                    $livre->setLangue($langue);
                }
                if (isset($results['volumeInfo']['authors'])) {
                    $authors = $results['volumeInfo']['authors'];
                    foreach ($authors as $authors) {
                        $auteur = $manager->getRepository(Auteur::class)->findOneBy(['intituleAuteur' => $authors]);
                        if ($auteur == null) {
                            $auteur = new Auteur();
                            $auteur->setIntituleauteur($authors);
                            $manager->persist($auteur);
                        }
                        $livre->addAuteur($auteur);
                    }
                }
                $manager->persist($livre);
                $manager->flush();
            }
        }
    }
}
