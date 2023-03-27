<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Langue
 *
 * @ORM\Table(name="langue")
 * @ORM\Entity
 */
class Langue
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
     * @ORM\Column(name="libelle_langue", type="string", length=255, nullable=false)
     */
    private $libelleLangue;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_langue", type="string", length=255, nullable=false)
     */
    private $nomLangue;


}
