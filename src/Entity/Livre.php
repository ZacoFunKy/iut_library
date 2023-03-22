<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use APP\Entity\Editeur;
use APP\Entity\Langue;


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
     * @ORM\ManyToMany(targetEntity="Categorie", inversedBy="idLivre")
     * @ORM\JoinTable(name="correspond",
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
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Emprunt", inversedBy="idLivre")
     * @ORM\JoinTable(name="emprunter",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_LIVRE", referencedColumnName="ID_LIVRE")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_EMPRUNT", referencedColumnName="ID_EMPRUNT")
     *   }
     * )
     */
    private $idEmprunt = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->nomcategorie = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idAuteur = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idEmprunt = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getIdLivre(): ?int
    {
        return $this->idLivre;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCouverture()
    {
        return $this->couverture;
    }

    public function setCouverture($couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }

    public function getDateparution(): ?\DateTimeInterface
    {
        return $this->dateparution;
    }

    public function setDateparution(?\DateTimeInterface $dateparution): self
    {
        $this->dateparution = $dateparution;

        return $this;
    }

    public function getPage(): ?string
    {
        return $this->page;
    }

    public function setPage(?string $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getDateacquisitions(): ?\DateTimeInterface
    {
        return $this->dateacquisitions;
    }

    public function setDateacquisitions(\DateTimeInterface $dateacquisitions): self
    {
        $this->dateacquisitions = $dateacquisitions;

        return $this;
    }

    public function getIdEditeur()
    {
        return $this->idEditeur;
    }

    public function setIdEditeur(?Editeur $idEditeur): self
    {
        $this->idEditeur = $idEditeur;

        return $this;
    }

    public function getLibellelangue()
    {
        return $this->libellelangue;
    }

    public function setLibellelangue(?Langue $libellelangue): self
    {
        $this->libellelangue = $libellelangue;

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getNomcategorie(): Collection
    {
        return $this->nomcategorie;
    }

    public function addNomcategorie(Categorie $nomcategorie): self
    {
        if (!$this->nomcategorie->contains($nomcategorie)) {
            $this->nomcategorie[] = $nomcategorie;
        }

        return $this;
    }

    public function removeNomcategorie(Categorie $nomcategorie): self
    {
        if ($this->nomcategorie->contains($nomcategorie)) {
            $this->nomcategorie->removeElement($nomcategorie);
        }

        return $this;
    }

    /**
     * @return Collection|Auteur[]
     */

    public function getIdAuteur(): Collection
    {
        return $this->idAuteur;
    }

    public function addIdAuteur(Auteur $idAuteur): self
    {
        if (!$this->idAuteur->contains($idAuteur)) {
            $this->idAuteur[] = $idAuteur;
            $idAuteur->addIdLivre($this);
        }

        return $this;
    }

    public function removeIdAuteur(Auteur $idAuteur): self
    {
        if ($this->idAuteur->contains($idAuteur)) {
            $this->idAuteur->removeElement($idAuteur);
            $idAuteur->removeIdLivre($this);
        }

        return $this;
    }

    /**
     * @return Collection|Emprunt[]
     */
    public function getIdEmprunt(): Collection
    {
        return $this->idEmprunt;
    }

    public function addIdEmprunt(Emprunt $idEmprunt): self
    {
        if (!$this->idEmprunt->contains($idEmprunt)) {
            $this->idEmprunt[] = $idEmprunt;
        }

        return $this;
    }

    public function removeIdEmprunt(Emprunt $idEmprunt): self
    {
        if ($this->idEmprunt->contains($idEmprunt)) {
            $this->idEmprunt->removeElement($idEmprunt);
        }

        return $this;
    }
}
