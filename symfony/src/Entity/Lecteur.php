<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use PhpParser\ErrorHandler\Collecting;
use Symfony\Component\Validator\Constraints\Collection;

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
     * @ORM\ManyToMany(targetEntity="Lecteur", mappedBy="idLecteurEstSuivi")
     */
    private $idLecteurSuit = array();


    /**
     * @var \Doctrine\Common\Collections\Collection
     * @ORM\ManyToMany(targetEntity="Lecteur", inversedBy="idLecteurSuit")
     * @ORM\JoinTable(name="SUIVRE",
     *  joinColumns={
     *     @ORM\JoinColumn(name="ID_LECTEUR", referencedColumnName="ID_LECTEUR")
     *  },
     * inverseJoinColumns={
     *    @ORM\JoinColumn(name="ID_LECTEUR_EST_SUIVI", referencedColumnName="ID_LECTEUR")
     * }
     * )
     */
    private $idLecteurEstSuivi = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLecteurSuit = new \Doctrine\Common\Collections\ArrayCollection();
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

    public function getImagedeprofil()
    {
        return $this->imagedeprofil;
    }

    public function setImagedeprofil($imagedeprofil): self
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


    public function addIdLecteurSuit(Lecteur $lecteur)
    {
        if (!$this->idLecteurSuit->contains($lecteur)) {
            $this->idLecteurSuit->add($lecteur);
            $lecteur->addIdLecteurEstSuivi($this);
        }
        return $this;
    }

    public function addIdLecteurEstSuivi(Lecteur $lecteur)
    {
        if (!$this->idLecteurEstSuivi->contains($lecteur)) {
            $this->idLecteurEstSuivi->add($lecteur);
            $lecteur->addIdLecteurSuit($this);
        }
        return $this;
    }
}