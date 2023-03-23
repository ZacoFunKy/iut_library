<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Langue
 *
 * @ORM\Table(name="LANGUE")
 * @ORM\Entity
 */
class Langue
{
    /**
     * @var string
     *
     * @ORM\Column(name="LIBELLELANGUE", type="string", length=32, nullable=false, options={"fixed"=true})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $libellelangue;

    /**
     * @var string
     *
     * @ORM\Column(name="NOMLANGUE", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $nomlangue;

    public function getLibellelangue(): ?string
    {
        return $this->libellelangue;
    }

    public function getNomlangue(): ?string
    {
        return $this->nomlangue;
    }

    public function setNomlangue(string $nomlangue): self
    {
        $this->nomlangue = $nomlangue;

        return $this;
    }
}
