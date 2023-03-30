<?php

namespace App\Entity;

use App\Repository\LivreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LivreRepository::class)]
class Livre
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 500)]
    #[Groups(['livre_basic', 'lecteur_basic'])]
    private ?string $titre = null;

    #[ORM\Column(length: 2555, nullable: true)]
    #[Groups(['livre_basic'])]
    private ?string $description = null;

    #[ORM\Column(length: 2555, nullable: true)]
    #[Groups(['livre_basic', 'lecteur_basic'])]
    private ?string $couverture = null;

    #[ORM\Column(nullable: true)]
    #[Groups(['livre_basic'])]
    private ?int $page = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['livre_basic'])]
    private ?\DateTimeInterface $dateAcquisition = null;

    #[ORM\OneToMany(mappedBy: 'livre', targetEntity: Emprunt::class, orphanRemoval: true)]
    private Collection $emprunts;

    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'livres')]
    #[ORM\JoinTable(name: 'livre_categorie')]
    #[Groups(['livre_basic'])]
    private Collection $categories;

    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[ORM\JoinColumn(nullable: true)]
    #[Groups(['livre_basic'])]
    private ?Langue $langue = null;


    #[ORM\ManyToMany(targetEntity: Auteur::class, inversedBy: 'livres')]
    #[Groups(['livre_basic'])]
    private Collection $auteurs;


    #[ORM\ManyToOne(inversedBy: 'livres')]
    #[Groups(['livre_basic'])]
    private ?Editeur $editeur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    #[Groups(['livre_basic'])]
    private ?\DateTimeInterface $dateParution = null;


    public function __construct()
    {
        $this->emprunts = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->auteurs = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function setPage(?int $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function getDateAcquisition(): ?\DateTimeInterface
    {
        return $this->dateAcquisition;
    }

    public function setDateAcquisition(\DateTimeInterface $dateAcquisition): self
    {
        $this->dateAcquisition = $dateAcquisition;

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
            $emprunt->setLivre($this);
        }

        return $this;
    }

    public function removeEmprunt(Emprunt $emprunt): self
    {
        if ($this->emprunts->removeElement($emprunt)) {
            // set the owning side to null (unless already changed)
            if ($emprunt->getLivre() === $this) {
                $emprunt->setLivre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }


    /**
     * @return Collection<int, Auteur>
     */
    public function getAuteurs(): Collection
    {
        return $this->auteurs;
    }

    public function addAuteur(Auteur $auteur): self
    {
        if (!$this->auteurs->contains($auteur)) {
            $this->auteurs->add($auteur);
        }

        return $this;
    }

    public function removeAuteur(Auteur $auteur): self
    {
        $this->auteurs->removeElement($auteur);

        return $this;
    }



    public function getEditeur(): ?Editeur
    {
        return $this->editeur;
    }

    public function setEditeur(?Editeur $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getDateParution(): ?\DateTimeInterface
    {
        return $this->dateParution;
    }

    public function setDateParution(?\DateTimeInterface $dateParution): self
    {
        $this->dateParution = $dateParution;

        return $this;
    }

    public function getCouverture(): ?string
    {
        return $this->couverture;
    }

    public function setCouverture(?string $couverture): self
    {
        $this->couverture = $couverture;

        return $this;
    }
}
