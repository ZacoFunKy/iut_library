<?php

namespace App\Entity;

use App\Repository\LecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LecteurRepository::class)]
class Lecteur
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nomLecteur = null;

    #[ORM\Column(length: 255)]
    private ?string $prenomLecteur = null;

    #[ORM\Column(type: Types::BLOB, nullable: true)]
    private $imageDeProfil = null;

    #[ORM\Column(length: 255)]
    private ?string $motDePasse = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'lecteursQuiMeSuivent')]
    private Collection $lecteursSuivis;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'lecteursSuivis')]
    private Collection $lecteursQuiMeSuivent;

    #[ORM\OneToMany(mappedBy: 'lecteur', targetEntity: Emprunt::class, orphanRemoval: true)]
    private Collection $emprunts;

    public function __construct()
    {
        $this->lecteursSuivis = new ArrayCollection();
        $this->lecteursQuiMeSuivent = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLecteur(): ?string
    {
        return $this->nomLecteur;
    }

    public function setNomLecteur(string $nomLecteur): self
    {
        $this->nomLecteur = $nomLecteur;

        return $this;
    }

    public function getPrenomLecteur(): ?string
    {
        return $this->prenomLecteur;
    }

    public function setPrenomLecteur(string $prenomLecteur): self
    {
        $this->prenomLecteur = $prenomLecteur;

        return $this;
    }

    public function getImageDeProfil()
    {
        return $this->imageDeProfil;
    }

    public function setImageDeProfil($imageDeProfil): self
    {
        $this->imageDeProfil = $imageDeProfil;

        return $this;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

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
     * @return Collection<int, self>
     */
    public function getLecteursSuivis(): Collection
    {
        return $this->lecteursSuivis;
    }

    public function addLecteursSuivi(self $lecteursSuivi): self
    {
        if (!$this->lecteursSuivis->contains($lecteursSuivi)) {
            $this->lecteursSuivis->add($lecteursSuivi);
        }

        return $this;
    }

    public function removeLecteursSuivi(self $lecteursSuivi): self
    {
        $this->lecteursSuivis->removeElement($lecteursSuivi);

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLecteursQuiMeSuivent(): Collection
    {
        return $this->lecteursQuiMeSuivent;
    }

    public function addLecteursQuiMeSuivent(self $lecteursQuiMeSuivent): self
    {
        if (!$this->lecteursQuiMeSuivent->contains($lecteursQuiMeSuivent)) {
            $this->lecteursQuiMeSuivent->add($lecteursQuiMeSuivent);
            $lecteursQuiMeSuivent->addLecteursSuivi($this);
        }

        return $this;
    }

    public function removeLecteursQuiMeSuivent(self $lecteursQuiMeSuivent): self
    {
        if ($this->lecteursQuiMeSuivent->removeElement($lecteursQuiMeSuivent)) {
            $lecteursQuiMeSuivent->removeLecteursSuivi($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getEmprunts(): Collection
    {
        return $this->emprunts;
    }

    public function addEmprunt(Emprunt $emprunt): self
    {
        if (!$this->emprunts->contains($emprunt)) {
            $this->emprunts->add($emprunt);
            $emprunt->setLecteur($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLecteur() === $this) {
                $emprunt->setLecteur(null);
            }
        }

        return $this;
    }
}
