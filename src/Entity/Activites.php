<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Activites
 *
 * @ORM\Table(name="activites", indexes={@ORM\Index(name="region_activites_KF", columns={"region_id"}), @ORM\Index(name="departement_activites_KF", columns={"departement_id"}), @ORM\Index(name="user_activites_KF", columns={"user_id"})})
 * @ORM\Entity
 */
class Activites
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_activites", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idActivites;

    /**
     * @var string
     *
     * @ORM\Column(name="name_actvites", type="string", length=50, nullable=false)
     */
    private $nameActvites;

    /**
     * @var string
     *
     * @ORM\Column(name="description_activites", type="text", length=65535, nullable=false)
     */
    private $descriptionActivites;

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo_activites", type="string", length=500, nullable=true)
     */
    private $photoActivites;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_activites", type="datetime", nullable=false)
     */
    private $dateActivites;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created_activites", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCreatedActivites = 'CURRENT_TIMESTAMP';

    /**
     * @var string
     *
     * @ORM\Column(name="location_activites", type="string", length=50, nullable=false)
     */
    private $locationActivites;

    /**
     * @var string
     *
     * @ORM\Column(name="price_activite", type="string", length=5, nullable=false)
     */
    private $priceActivite;

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="departement_id", referencedColumnName="id_department")
     * })
     */
    private $departement;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="region_id", referencedColumnName="id_region")
     * })
     */
    private $region;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id_user")
     * })
     */
    private $user;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="activitesFk")
     */
    private $idActivitesUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idActivitesUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdActivites(): ?int
    {
        return $this->idActivites;
    }

    public function getNameActvites(): ?string
    {
        return $this->nameActvites;
    }

    public function setNameActvites(string $nameActvites): self
    {
        $this->nameActvites = $nameActvites;

        return $this;
    }

    public function getDescriptionActivites(): ?string
    {
        return $this->descriptionActivites;
    }

    public function setDescriptionActivites(string $descriptionActivites): self
    {
        $this->descriptionActivites = $descriptionActivites;

        return $this;
    }

    public function getPhotoActivites(): ?string
    {
        return $this->photoActivites;
    }

    public function setPhotoActivites(?string $photoActivites): self
    {
        $this->photoActivites = $photoActivites;

        return $this;
    }

    public function getDateActivites(): ?\DateTimeInterface
    {
        return $this->dateActivites;
    }

    public function setDateActivites(\DateTimeInterface $dateActivites): self
    {
        $this->dateActivites = $dateActivites;

        return $this;
    }

    public function getDateCreatedActivites(): ?\DateTimeInterface
    {
        return $this->dateCreatedActivites;
    }

    public function setDateCreatedActivites(\DateTimeInterface $dateCreatedActivites): self
    {
        $this->dateCreatedActivites = $dateCreatedActivites;

        return $this;
    }

    public function getLocationActivites(): ?string
    {
        return $this->locationActivites;
    }

    public function setLocationActivites(string $locationActivites): self
    {
        $this->locationActivites = $locationActivites;

        return $this;
    }

    public function getPriceActivite(): ?string
    {
        return $this->priceActivite;
    }

    public function setPriceActivite(string $priceActivite): self
    {
        $this->priceActivite = $priceActivite;

        return $this;
    }

    public function getDepartement(): ?Departement
    {
        return $this->departement;
    }

    public function setDepartement(?Departement $departement): self
    {
        $this->departement = $departement;

        return $this;
    }

    public function getRegion(): ?Region
    {
        return $this->region;
    }

    public function setRegion(?Region $region): self
    {
        $this->region = $region;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getIdActivitesUser(): Collection
    {
        return $this->idActivitesUser;
    }

    public function addIdActivitesUser(Users $idActivitesUser): self
    {
        if (!$this->idActivitesUser->contains($idActivitesUser)) {
            $this->idActivitesUser[] = $idActivitesUser;
            $idActivitesUser->addActivitesFk($this);
        }

        return $this;
    }

    public function removeIdActivitesUser(Users $idActivitesUser): self
    {
        if ($this->idActivitesUser->contains($idActivitesUser)) {
            $this->idActivitesUser->removeElement($idActivitesUser);
            $idActivitesUser->removeActivitesFk($this);
        }

        return $this;
    }

}
