<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
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
     * @ORM\Column(name="nom_categorie", type="string", length=255, nullable=false)
     */
    private $nomCategorie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Livre", mappedBy="categorie")
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
