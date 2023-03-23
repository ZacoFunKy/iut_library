<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="CATEGORIE")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var string
     *
     * @ORM\Column(name="NOMCATEGORIE", type="string", length=32, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $nomcategorie;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Livre", mappedBy="nomcategorie")
     */
    private $idLivre = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idLivre = new \Doctrine\Common\Collections\ArrayCollection();
    }


    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(string $nomcategorie): self
    {
        $this->nomcategorie = $nomcategorie;
        return $this;
    }


    public function addIdLivre(Livre $idLivre): self
    {
        if (!$this->idLivre->contains($idLivre)) {
            $this->idLivre[] = $idLivre;
            $idLivre->addNomcategorie($this);
        }
        return $this;
    }

    public function removeIdLivre(Livre $idLivre): self
    {
        if ($this->idLivre->contains($idLivre)) {
            $this->idLivre->removeElement($idLivre);
            $idLivre->removeNomcategorie($this);
        }
        return $this;
    }
}