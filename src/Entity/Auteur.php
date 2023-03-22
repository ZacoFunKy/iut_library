<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Auteur
 *
 * @ORM\Table(name="AUTEUR")
 * @ORM\Entity
 */
class Auteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_AUTEUR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="INTITULEAUTEUR", type="string", length=255, nullable=false, options={"fixed"=true})
     */
    private $intituleauteur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Livre", inversedBy="idAuteur")
     * @ORM\JoinTable(name="ecrire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_AUTEUR", referencedColumnName="ID_AUTEUR")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_LIVRE", referencedColumnName="ID_LIVRE")
     *   }
     * )
     */
    private $idLivre = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLivre = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdAuteur(): ?int
    {
        return $this->idAuteur;
    }

    public function getIntituleauteur(): ?string
    {
        return $this->intituleauteur;
    }

    public function setIntituleauteur(string $intituleauteur): self
    {
        $this->intituleauteur = $intituleauteur;

        return $this;
    }

    /**
     * @return Collection|Livre[]
     */
    public function getIdLivre(): Collection
    {
        return $this->idLivre;
    }

    public function addIdLivre(Livre $idLivre): self
    {
        if (!$this->idLivre->contains($idLivre)) {
            $this->idLivre[] = $idLivre;
            $idLivre->addIdAuteur($this);
        }

        return $this;
    }

    public function removeIdLivre(Livre $idLivre): self
    {
        if ($this->idLivre->contains($idLivre)) {
            $this->idLivre->removeElement($idLivre);
            $idLivre->removeIdAuteur($this);
        }

        return $this;
    }

     

}
