<?php

namespace App\Entity;

use App\Repository\LecteurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LecteurRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Lecteur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['livre_basic'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\NotBlank]
    #[Groups(['livre_basic', 'lecteur_basic'])]
    private ?string $email = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['livre_basic', 'lecteur_basic'])]
    private ?string $nomLecteur = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Groups(['livre_basic', 'lecteur_basic'])]
    private ?string $prenomLecteur = null;

    #[ORM\Column(length: 2555, nullable: true)]

    #[Groups(['livre_basic', 'lecteur_basic'])]
    private $imageDeProfil = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'lecteursQuiMeSuivent')]
    private Collection $lecteursSuivis;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'lecteursSuivis')]
    private Collection $lecteursQuiMeSuivent;

    #[ORM\OneToMany(mappedBy: 'lecteur', targetEntity: Emprunt::class, orphanRemoval: true)]
    #[Groups(['lecteur_basic'])]
    private Collection $emprunts;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $token = null;

    public function __construct()
    {
        $this->lecteursSuivis = new ArrayCollection();
        $this->lecteursQuiMeSuivent = new ArrayCollection();
        $this->emprunts = new ArrayCollection();
        $ro = ["ROLE_USER"];
        $this->setRoles($ro);
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getNomlecteur(): ?string
    {
        return $this->nomLecteur;
    }

    public function setNomlecteur(string $nomlecteur): self
    {
        $this->nomLecteur = $nomlecteur;

        return $this;
    }

    public function getPrenomlecteur(): ?string
    {
        return $this->prenomLecteur;
    }

    public function setPrenomlecteur(string $prenomlecteur): self
    {
        $this->prenomLecteur = $prenomlecteur;

        return $this;
    }

    public function getImagedeprofil()
    {
        return $this->imageDeProfil;
    }

    public function setImagedeprofil($imagedeprofil): self
    {
        $this->imageDeProfil = $imagedeprofil;

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
    public function getEmprunts(): array
    {
        return $this->emprunts->slice(0, 3);
    }

    public function get4DerniersEmprunts(): array
    {
        return $this->emprunts->slice(0, 4);
    }

    /**
     * @return Collection<int, Emprunt>
     */
    public function getAllEmprunts(): Collection
    {

        return $this->emprunts;
    }

    public function setEmprunts(array $newEmprunt): array
    {
        $emprunts = $this->emprunts->toArray();
        $emprunts = $newEmprunt;

        return $emprunts;
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

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;

        return $this;
    }
}
