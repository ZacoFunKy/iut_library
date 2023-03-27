<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre
 *
 * @ORM\Table(name="livre", indexes={@ORM\Index(name="IDX_AC634F992AADBACD", columns={"langue_id"}), @ORM\Index(name="IDX_AC634F993375BD21", columns={"editeur_id"})})
 * @ORM\Entity
 */
class Livre
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
     * @ORM\Column(name="titre", type="string", length=500, nullable=false)
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=2555, nullable=true)
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="couverture", type="blob", length=0, nullable=true)
     */
    private $couverture;

    /**
     * @var int|null
     *
     * @ORM\Column(name="page", type="integer", nullable=true)
     */
    private $page;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_acquisition", type="datetime", nullable=false)
     */
    private $dateAcquisition;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_parution", type="datetime", nullable=true)
     */
    private $dateParution;

    /**
     * @var \Langue
     *
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="langue_id", referencedColumnName="id")
     * })
     */
    private $langue;

    /**
     * @var \Editeur
     *
     * @ORM\ManyToOne(targetEntity="Editeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="editeur_id", referencedColumnName="id")
     * })
     */
    private $editeur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="livre")
     * @ORM\JoinTable(name="livre_categorie",
     *   joinColumns={
     *     @ORM\JoinColumn(name="livre_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="categorie_id", referencedColumnName="id")
     *   }
     * )
     */
    private $categorie = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Auteur", inversedBy="livre")
     * @ORM\JoinTable(name="livre_auteur",
     *   joinColumns={
     *     @ORM\JoinColumn(name="livre_id", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="auteur_id", referencedColumnName="id")
     *   }
     * )
     */
    private $auteur = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->categorie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->auteur = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
