<?php

namespace App\DataFixtures;

use App\Entity\Lecteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class SuiviFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $lecteurs = $manager->getRepository(Lecteur::class)->findAll();
        foreach ($lecteurs as $lecteur) {
            $nbSuivi = rand(0, 5);
            for ($i = 0; $i < $nbSuivi; $i++) {
                $lecteurSuivi = $lecteurs[rand(0, count($lecteurs) - 1)];
                if ($lecteurSuivi != $lecteur) {
                    $lecteur->addLecteursSuivi($lecteurSuivi);
                }
            }
            $manager->persist($lecteur);
        }

        $manager->flush();
    }
}
