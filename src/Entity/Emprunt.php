<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Emprunt
 *
 * @ORM\Table(name="EMPRUNT")
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
     * @ORM\Column(name="DATERETOUR", type="datetime", nullable=true)
     */
    private $dateretour;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Livre", mappedBy="idEmprunt")
     */
    private $idLivre = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lecteur", inversedBy="idEmprunt")
     * @ORM\JoinTable(name="faire",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_EMPRUNT", referencedColumnName="ID_EMPRUNT")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_LECTEUR", referencedColumnName="ID_LECTEUR")
     *   }
     * )
     */
    private $idLecteur = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLivre = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idLecteur = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdEmprunt(): ?int
    {
        return $this->idEmprunt;
    }

    public function getDateemprunt(): ?\DateTimeInterface
    {
        return $this->dateemprunt;
    }

    public function setDateemprunt(\DateTimeInterface $dateemprunt): self
    {
        $this->dateemprunt = $dateemprunt;

        return $this;
    }

    public function getDateretour(): ?\DateTimeInterface
    {
        return $this->dateretour;
    }

    public function setDateretour(?\DateTimeInterface $dateretour): self
    {
        $this->dateretour = $dateretour;

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
            $idLivre->addIdEmprunt($this);
        }

        return $this;
    }

    public function removeIdLivre(Livre $idLivre): self
    {
        if ($this->idLivre->contains($idLivre)) {
            $this->idLivre->removeElement($idLivre);
            $idLivre->removeIdEmprunt($this);
        }

        return $this;
    }

    /**
     * @return Collection|Lecteur[]
     */
    public function getIdLecteur(): Collection
    {
        return $this->idLecteur;
    }

    public function addIdLecteur(Lecteur $idLecteur): self
    {
        if (!$this->idLecteur->contains($idLecteur)) {
            $this->idLecteur[] = $idLecteur;
            $idLecteur->addIdEmprunt($this);
        }

        return $this;
    }

    public function removeIdLecteur(Lecteur $idLecteur): self
    {
        if ($this->idLecteur->contains($idLecteur)) {
            $this->idLecteur->removeElement($idLecteur);
            $idLecteur->removeIdEmprunt($this);
        }

        return $this;
    }

    
}
