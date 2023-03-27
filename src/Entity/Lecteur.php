<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Lecteur
 *
 * @ORM\Table(name="lecteur")
 * @ORM\Entity
 */
class Lecteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_lecteur", type="string", length=255, nullable=false)
     */
    private $nomLecteur;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_lecteur", type="string", length=255, nullable=false)
     */
    private $prenomLecteur;

    /**
     * @var string|null
     *
     * @ORM\Column(name="image_de_profil", type="blob", length=0, nullable=true)
     */
    private $imageDeProfil;

    /**
     * @var string
     *
     * @ORM\Column(name="mot_de_passe", type="string", length=255, nullable=false)
     */
    private $motDePasse;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255, nullable=false)
     */
    private $email;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Lecteur", inversedBy="lecteurSource")
     * @ORM\JoinTable(name="lecteur_lecteur",
     *   joinColumns={
     *     @ORM\JoinColumn(name="lecteur_source", referencedColumnName="id")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="lecteur_target", referencedColumnName="id")
     *   }
     * )
     */
    private $lecteurTarget = array();

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lecteurTarget = new \Doctrine\Common\Collections\ArrayCollection();
    }

}
