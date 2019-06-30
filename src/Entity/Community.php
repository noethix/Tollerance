<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Community
 *
 * @ORM\Table(name="community", indexes={@ORM\Index(name="community_departement_FK", columns={"community_departement_id"}), @ORM\Index(name="community_region_FK", columns={"community_region_id"})})
 * @ORM\Entity
 */
class Community
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_community", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommunity;

    /**
     * @var string
     *
     * @ORM\Column(name="name_community", type="string", length=50, nullable=false)
     */
    private $nameCommunity;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_community", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDateCommunity = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="description_community", type="text", length=65535, nullable=false)
     */
    private $descriptionCommunity;

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="community_departement_id", referencedColumnName="id_department")
     * })
     */
    private $communityDepartement;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="community_region_id", referencedColumnName="id_region")
     * })
     */
    private $communityRegion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="idCommunityFk")
     */
    private $idCommunityUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCommunityUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCommunity(): ?int
    {
        return $this->idCommunity;
    }

    public function getNameCommunity(): ?string
    {
        return $this->nameCommunity;
    }

    public function setNameCommunity(string $nameCommunity): self
    {
        $this->nameCommunity = $nameCommunity;

        return $this;
    }

    public function getCreatedDateCommunity(): ?\DateTimeInterface
    {
        return $this->createdDateCommunity;
    }

    public function setCreatedDateCommunity(\DateTimeInterface $createdDateCommunity): self
    {
        $this->createdDateCommunity = $createdDateCommunity;

        return $this;
    }

    public function getDescriptionCommunity(): ?string
    {
        return $this->descriptionCommunity;
    }

    public function setDescriptionCommunity(string $descriptionCommunity): self
    {
        $this->descriptionCommunity = $descriptionCommunity;

        return $this;
    }

    public function getCommunityDepartement(): ?Departement
    {
        return $this->communityDepartement;
    }

    public function setCommunityDepartement(?Departement $communityDepartement): self
    {
        $this->communityDepartement = $communityDepartement;

        return $this;
    }

    public function getCommunityRegion(): ?Region
    {
        return $this->communityRegion;
    }

    public function setCommunityRegion(?Region $communityRegion): self
    {
        $this->communityRegion = $communityRegion;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdCommunityUser(): Collection
    {
        return $this->idCommunityUser;
    }

    public function addIdCommunityUser(Users $idCommunityUser): self
    {
        if (!$this->idCommunityUser->contains($idCommunityUser)) {
            $this->idCommunityUser[] = $idCommunityUser;
            $idCommunityUser->addIdCommunityFk($this);
        }

        return $this;
    }

    public function removeIdCommunityUser(Users $idCommunityUser): self
    {
        if ($this->idCommunityUser->contains($idCommunityUser)) {
            $this->idCommunityUser->removeElement($idCommunityUser);
            $idCommunityUser->removeIdCommunityFk($this);
        }

        return $this;
    }

}
