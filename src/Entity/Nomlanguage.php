<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Nomlanguage
 *
 * @ORM\Table(name="NOMLANGUAGE")
 * @ORM\Entity
 */
class Nomlanguage
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
     * @ORM\Column(name="NOMLANGAGE", type="string", length=32, nullable=false, options={"fixed"=true})
     */
    private $nomlangage;

    public function getLibellelangue(): ?string
    {
        return $this->libellelangue;
    }

    public function getNomlangage(): ?string
    {
        return $this->nomlangage;
    }

    public function setNomlangage(string $nomlangage): self
    {
        $this->nomlangage = $nomlangage;

        return $this;
    }

    


}
