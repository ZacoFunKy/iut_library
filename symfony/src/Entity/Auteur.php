<?php

namespace App\Entity;

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
     * @var string|null
     *
     * @ORM\Column(name="INTUITULEAUTEUR", type="string", length=32, nullable=true, options={"fixed"=true})
     */
    private $intuituleauteur;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="LIVRE", inversedBy="idAuteur")
     * @ORM\JoinTable(name="ECRIRE",
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

    public function getIntuituleauteur(): ?string
    {
        return $this->intuituleauteur;
    }

    public function setIntuituleauteur(?string $intuituleauteur): self
    {
        $this->intuituleauteur = $intuituleauteur;

        return $this;
    }

    public function addIdLivre(Livre $idLivre): self
    {
        if (!$this->idLivre->contains($idLivre)) {
            $this->idLivre[] = $idLivre;
        }

        return $this;
    }

    public function removeIdLivre(Livre $idLivre): self
    {
        if ($this->idLivre->contains($idLivre)) {
            $this->idLivre->removeElement($idLivre);
        }

        return $this;
    }

}
