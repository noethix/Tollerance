<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Departement
 *
 * @ORM\Table(name="departement", indexes={@ORM\Index(name="region_id", columns={"departement_region_id"})})
 * @ORM\Entity
 */
class Departement
{
    /**
     * @var string
     *
     * @ORM\Column(name="id_department", type="string", length=11, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDepartment;

    /**
     * @var string
     *
     * @ORM\Column(name="name_department", type="string", length=100, nullable=false)
     */
    private $nameDepartment;

    /**
     * @var string
     *
     * @ORM\Column(name="number_department", type="string", length=11, nullable=false)
     */
    private $numberDepartment;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departement_region_id", referencedColumnName="id_region")
     * })
     */
    private $departementRegion;

    public function getIdDepartment(): ?string
    {
        return $this->idDepartment;
    }

    public function getNameDepartment(): ?string
    {
        return $this->nameDepartment;
    }

    public function setNameDepartment(string $nameDepartment): self
    {
        $this->nameDepartment = $nameDepartment;

        return $this;
    }

    public function getNumberDepartment(): ?string
    {
        return $this->numberDepartment;
    }

    public function setNumberDepartment(string $numberDepartment): self
    {
        $this->numberDepartment = $numberDepartment;

        return $this;
    }

    public function getDepartementRegion(): ?Region
    {
        return $this->departementRegion;
    }

    public function setDepartementRegion(?Region $departementRegion): self
    {
        $this->departementRegion = $departementRegion;

        return $this;
    }


}
