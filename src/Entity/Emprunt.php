<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 *
 * @ORM\Table(name="emprunt", indexes={@ORM\Index(name="IDX_364071D749DB9E60", columns={"lecteur_id"}), @ORM\Index(name="IDX_364071D737D925CB", columns={"livre_id"})})
 * @ORM\Entity
 */
class Emprunt
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_emprunt", type="datetime", nullable=false)
     */
    private $dateEmprunt;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_rendu", type="datetime", nullable=true)
     */
    private $dateRendu;

    /**
     * @var \Livre
     *
     * @ORM\ManyToOne(targetEntity="Livre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="livre_id", referencedColumnName="id")
     * })
     */
    private $livre;

    /**
     * @var \Lecteur
     *
     * @ORM\ManyToOne(targetEntity="Lecteur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="lecteur_id", referencedColumnName="id")
     * })
     */
    private $lecteur;


}
