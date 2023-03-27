<?php

namespace App\DataFixtures;

use App\Entity\Lecteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class LecteurFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $base_url = "https://randomuser.me/api?results=100";
        $json = file_get_contents($base_url);
        $data = json_decode($json, true);
        $results = $data['results'];
        foreach ($results as $result) {
            $lecteur = new Lecteur();
            $lecteur->setNomlecteur($result['name']['last']);
            $lecteur->setPrenomlecteur($result['name']['first']);
            $lecteur->setEmail($result['email']);
            $password = $result['login']['password'];
            $lecteur->setMotdepasse(hash('sha256', $password));
            $lecteur->setImagedeprofil($result['picture']['large']);
            $manager->persist($lecteur);
        }
        $manager->flush();
    }
}
