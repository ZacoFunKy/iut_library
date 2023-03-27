<?php

namespace App\Entity;

use App\Repository\LangueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: LangueRepository::class)]
class Langue
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $libelleLangue = null;

    #[ORM\Column(length: 255)]
    #[Groups(['livre_basic'])]
    private ?string $nomLangue = null;

    #[ORM\OneToMany(mappedBy: 'langue', targetEntity: Livre::class, orphanRemoval: true)]
    private Collection $livres;

    public function __construct()
    {
        $this->livres = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleLangue(): ?string
    {
        return $this->libelleLangue;
    }

    public function setLibelleLangue(string $libelleLangue): self
    {
        $this->libelleLangue = $libelleLangue;

        return $this;
    }

    public function getNomLangue(): ?string
    {
        return $this->nomLangue;
    }

    public function setNomLangue(string $nomLangue): self
    {
        $this->nomLangue = $nomLangue;

        return $this;
    }

    /**
     * @return Collection<int, Livre>
     */
    public function getLivres(): Collection
    {
        return $this->livres;
    }

    public function addLivre(Livre $livre): self
    {
        if (!$this->livres->contains($livre)) {
            $this->livres->add($livre);
            $livre->setLangue($this);
        }

        return $this;
    }

    public function removeLivre(Livre $livre): self
    {
        if ($this->livres->removeElement($livre)) {
            // set the owning side to null (unless already changed)
            if ($livre->getLangue() === $this) {
                $livre->setLangue(null);
            }
        }

        return $this;
    }
}
