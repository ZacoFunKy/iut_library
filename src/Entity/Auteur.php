<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Auteur
 *
 * @ORM\Table(name="auteur")
 * @ORM\Entity
 */
class Auteur
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
     * @var string
     *
     * @ORM\Column(name="intitule_auteur", type="string", length=255, nullable=false)
     */
    private $intituleAuteur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Livre", mappedBy="auteur")
     */
    private $livre = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->livre = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
