<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Groupes
 *
 * @ORM\Table(name="groupes", indexes={@ORM\Index(name="groupe_departement_FK", columns={"groupes_departement_id"}), @ORM\Index(name="groupe_region_FK", columns={"groupes_region_id"})})
 * @ORM\Entity
 */
class Groupes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_groupe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGroupe;

    /**
     * @var string
     *
     * @ORM\Column(name="name_group", type="string", length=50, nullable=false)
     */
    private $nameGroup;

    /**
     * @var string
     *
     * @ORM\Column(name="description_groupe", type="string", length=200, nullable=false)
     */
    private $descriptionGroupe;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_group", type="string", length=50, nullable=true)
     */
    private $photoGroup;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created_groupe", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCreatedGroupe = 'CURRENT_TIMESTAMP';

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupes_departement_id", referencedColumnName="id_department")
     * })
     */
    private $groupesDepartement;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="groupes_region_id", referencedColumnName="id_region")
     * })
     */
    private $groupesRegion;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="groupesFk")
     */
    private $groupesUser;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by", referencedColumnName="id_user")
     * })
     */
    private $createdBy;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->groupesUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdGroupe(): ?int
    {
        return $this->idGroupe;
    }

    public function getNameGroup(): ?string
    {
        return $this->nameGroup;
    }

    public function setNameGroup(string $nameGroup): self
    {
        $this->nameGroup = $nameGroup;

        return $this;
    }

    public function getDescriptionGroupe(): ?string
    {
        return $this->descriptionGroupe;
    }

    public function setDescriptionGroupe(string $descriptionGroupe): self
    {
        $this->descriptionGroupe = $descriptionGroupe;

        return $this;
    }

    public function getPhotoGroup(): ?string
    {
        return $this->photoGroup;
    }

    public function setPhotoGroup(?string $photoGroup): self
    {
        $this->photoGroup = $photoGroup;

        return $this;
    }

    public function getDateCreatedGroupe(): ?\DateTimeInterface
    {
        return $this->dateCreatedGroupe;
    }

    public function setDateCreatedGroupe(\DateTimeInterface $dateCreatedGroupe): self
    {
        $this->dateCreatedGroupe = $dateCreatedGroupe;

        return $this;
    }

    public function getGroupesDepartement(): ?Departement
    {
        return $this->groupesDepartement;
    }

    public function setGroupesDepartement(?Departement $groupesDepartement): self
    {
        $this->groupesDepartement = $groupesDepartement;

        return $this;
    }

    public function getGroupesRegion(): ?Region
    {
        return $this->groupesRegion;
    }

    public function setGroupesRegion(?Region $groupesRegion): self
    {
        $this->groupesRegion = $groupesRegion;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getGroupesUser(): Collection
    {
        return $this->groupesUser;
    }

    public function addGroupesUser(Users $groupesUser): self
    {
        if (!$this->groupesUser->contains($groupesUser)) {
            $this->groupesUser[] = $groupesUser;
            $groupesUser->addGroupesFk($this);
        }

        return $this;
    }

    public function removeGroupesUser(Users $groupesUser): self
    {
        if ($this->groupesUser->contains($groupesUser)) {
            $this->groupesUser->removeElement($groupesUser);
            $groupesUser->removeGroupesFk($this);
        }

        return $this;
    }

    public function getCreatedBy(): ?Users
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?Users $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }


}
