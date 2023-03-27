<?php

namespace App\DataFixtures;

use App\Entity\Lecteur;
use App\Entity\Livre;
use App\Entity\Emprunt;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EmpruntFixtures extends Fixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager): void
    {

        $lecteurs = $manager->getRepository(Lecteur::class)->findAll();
        $livres = $manager->getRepository(Livre::class)->findAll();
        foreach ($lecteurs as $lecteur) {
            $probaEmprunt = rand(0, 100);
            if ($probaEmprunt < 80) {
                $nbEmprunt = rand(0, 10);
                for ($i = 0; $i < $nbEmprunt; $i++) {
                    $emprunt = new Emprunt();
                    $livre = $livres[rand(0, count($livres) - 1)];
                    $emprunt->setLivre($livre);
                    $emprunt->setLecteur($lecteur);
                    $aujourdhui = time();
                    $avant =  strtotime('-2 years');
                    $randomDate = mt_rand($avant, $aujourdhui);
                    $dateEmprunt = new \DateTime();
                    $dateEmprunt->setTimestamp($randomDate);
                    $emprunt->setDateEmprunt($dateEmprunt);
                    $manager->persist($emprunt);
                    $lecteur->addEmprunt($emprunt);
                }
            }
            $manager->persist($lecteur);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
