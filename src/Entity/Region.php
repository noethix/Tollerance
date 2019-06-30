<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity
 */
class Region
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_region", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="name_region", type="text", length=65535, nullable=false)
     */
    private $nameRegion;

    /**
     * @var string
     *
     * @ORM\Column(name="region_assimilee", type="string", length=100, nullable=false)
     */
    private $regionAssimilee;

    public function getIdRegion(): ?int
    {
        return $this->idRegion;
    }

    public function getNameRegion(): ?string
    {
        return $this->nameRegion;
    }

    public function setNameRegion(string $nameRegion): self
    {
        $this->nameRegion = $nameRegion;

        return $this;
    }

    public function getRegionAssimilee(): ?string
    {
        return $this->regionAssimilee;
    }

    public function setRegionAssimilee(string $regionAssimilee): self
    {
        $this->regionAssimilee = $regionAssimilee;

        return $this;
    }


}
