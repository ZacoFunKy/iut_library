<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Editeur
 *
 * @ORM\Table(name="EDITEUR")
 * @ORM\Entity
 */
class Editeur
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_EDITEUR", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEditeur;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMEDITEUR", type="string", length=255, nullable=false, options={"fixed"=true})
     */
    private $nomediteur;



    /**
     * Get idEditeur.
     *
     * @return int
     */
    public function getIdEditeur()
    {
        return $this->idEditeur;
    }

    /**
     * Set nomediteur.
     *
     * @param string $nomediteur
     *
     * @return Editeur
     */
    public function setNomediteur($nomediteur)
    {
        $this->nomediteur = $nomediteur;

        return $this;
    }
}
