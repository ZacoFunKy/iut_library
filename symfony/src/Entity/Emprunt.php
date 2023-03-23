<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 *
 * @ORM\Table(name="EMPRUNT", indexes={@ORM\Index(name="I_FK_EMPRUNT_LECTEUR",
 * columns={"ID_LECTEUR"}),
 * @ORM\Index(name="I_FK_EMPRUNT_LIVRE", columns={"ID_LIVRE"})})
 * @ORM\Entity
 */
class Emprunt
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_EMPRUNT", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmprunt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEEMPRUNT", type="datetime", nullable=false)
     */
    private $dateemprunt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATERENDU", type="datetime", nullable=true)
     */
    private $daterendu;

    /**
     * @var \Lecteur
     *
     * @ORM\ManyToOne(targetEntity="Lecteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_LECTEUR", referencedColumnName="ID_LECTEUR")
     * })
     */
    private $idLecteur;

    /**
     * @var \Livre
     *
     * @ORM\ManyToOne(targetEntity="Livre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_LIVRE", referencedColumnName="ID_LIVRE")
     * })
     */
    private $idLivre;
    
}