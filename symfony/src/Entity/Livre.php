<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Livre
 *
 * @ORM\Table(name="LIVRE", indexes={@ORM\Index(name="I_FK_LIVRE_LANGUE", columns={"LIBELLELANGUE"}), @ORM\Index(name="I_FK_LIVRE_EDITEUR", columns={"ID_EDITEUR"})})
 * @ORM\Entity
 */
class Livre
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_LIVRE", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLivre;

    /**
     * @var string
     *
     * @ORM\Column(name="TITRE", type="string", length=255, nullable=false, options={"fixed"=true})
     */
    private $titre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="DESCRIPTION", type="string", length=255, nullable=true, options={"fixed"=true})
     */
    private $description;

    /**
     * @var string|null
     *
     * @ORM\Column(name="COUVERTURE", type="blob", length=0, nullable=true)
     */
    private $couverture;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATEPARUTION", type="date", nullable=true)
     */
    private $dateparution;

    /**
     * @var int|null
     *
     * @ORM\Column(name="PAGE", type="bigint", nullable=true)
     */
    private $page;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="DATEACQUISITIONS", type="date", nullable=false)
     */
    private $dateacquisitions;

    /**
     * @var \Editeur
     *
     * @ORM\ManyToOne(targetEntity="Editeur")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_EDITEUR", referencedColumnName="ID_EDITEUR")
     * })
     */
    private $idEditeur;

    /**
     * @var \Langue
     *
     * @ORM\ManyToOne(targetEntity="Langue")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="LIBELLELANGUE", referencedColumnName="LIBELLELANGUE")
     * })
     */
    private $libellelangue;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="CATEGORIE", inversedBy="idLivre")
     * @ORM\JoinTable(name="CATEGORISE",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_LIVRE", referencedColumnName="ID_LIVRE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="NOMCATEGORIE", referencedColumnName="NOMCATEGORIE")
     *   }
     * )
     */
    private $nomcategorie = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Auteur", mappedBy="idLivre")
     */
    private $idAuteur = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nomcategorie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idAuteur = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
