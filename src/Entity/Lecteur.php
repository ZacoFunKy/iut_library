<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Lecteur
 *
 * @ORM\Table(name="LECTEUR")
 * @ORM\Entity
 */
class Lecteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_LECTEUR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idLecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMLECTEUR", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $nomlecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="PRENOMLECTEUR", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $prenomlecteur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMAGEDEPROFIL", type="blob", length=0, nullable=true)
     */
    private $imagedeprofil;

    /**
     * @var string
     *
     * @ORM\Column(name="MOTDEPASSE", type="string", length=255, nullable=false, options={"fixed"=true})
     */
    private $motdepasse;

    /**
     * @var string
     *
     * @ORM\Column(name="EMAIL", type="string", length=255, nullable=false, options={"fixed"=true})
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lecteur", inversedBy="idLecteurSuit")
     * @ORM\JoinTable(name="suivre",
     *   joinColumns={
     *     @ORM\JoinColumn(name="ID_LECTEUR_SUIT", referencedColumnName="ID_LECTEUR")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="ID_LECTEUR_EST_SUIVI", referencedColumnName="ID_LECTEUR")
     *   }
     * )
     */
    private $idLecteurEstSuivi = array();

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Emprunt", mappedBy="idLecteur")
     */
    private $idEmprunt = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLecteurEstSuivi = new \Doctrine\Common\Collections\ArrayCollection();
        $this->idEmprunt = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdLecteur(): ?int
    {
        return $this->idLecteur;
    }

    public function getNomlecteur(): ?string
    {
        return $this->nomlecteur;
    }

    public function setNomlecteur(string $nomlecteur): self
    {
        $this->nomlecteur = $nomlecteur;

        return $this;
    }

    public function getPrenomlecteur(): ?string
    {
        return $this->prenomlecteur;
    }

    public function setPrenomlecteur(string $prenomlecteur): self
    {
        $this->prenomlecteur = $prenomlecteur;

        return $this;
    }

    public function getImagedeprofil(): ?string
    {
        return $this->imagedeprofil;
    }

    public function setImagedeprofil(?string $imagedeprofil): self
    {
        $this->imagedeprofil = $imagedeprofil;

        return $this;
    }

    public function getMotdepasse(): ?string
    {
        return $this->motdepasse;
    }

    public function setMotdepasse(string $motdepasse): self
    {
        $this->motdepasse = $motdepasse;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getIdLecteurEstSuivi(): Collection

    {
        return $this->idLecteurEstSuivi;
    }

    public function addIdLecteurEstSuivi(self $idLecteurEstSuivi): self
    {
        if (!$this->idLecteurEstSuivi->contains($idLecteurEstSuivi)) {
            $this->idLecteurEstSuivi[] = $idLecteurEstSuivi;
        }

        return $this;
    }

    public function removeIdLecteurEstSuivi(self $idLecteurEstSuivi): self
    {
        if ($this->idLecteurEstSuivi->contains($idLecteurEstSuivi)) {
            $this->idLecteurEstSuivi->removeElement($idLecteurEstSuivi);
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
            $idEmprunt->addIdLecteur($this);
        }

        return $this;
    }

    public function removeIdEmprunt(Emprunt $idEmprunt): self
    {
        if ($this->idEmprunt->contains($idEmprunt)) {
            $this->idEmprunt->removeElement($idEmprunt);
            $idEmprunt->removeIdLecteur($this);
        }

        return $this;
    }


    

}
