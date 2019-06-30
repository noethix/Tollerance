<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Events
 *
 * @ORM\Table(name="events", indexes={@ORM\Index(name="Events_Departement_FK", columns={"events_departement_id"}), @ORM\Index(name="Events_Users_FK", columns={"created_by_user_id"}), @ORM\Index(name="Events_Region_FK", columns={"events_region_id"})})
 * @ORM\Entity
 */
class Events
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="Price", type="decimal", precision=10, scale=0, nullable=false)
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="name_event", type="string", length=50, nullable=false)
     */
    private $nameEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="description_event", type="text", length=65535, nullable=false)
     */
    private $descriptionEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="place_event", type="string", length=50, nullable=false)
     */
    private $placeEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_event", type="datetime", nullable=false)
     */
    private $dateEvent;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_created_event", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateCreatedEvent = 'CURRENT_TIMESTAMP';

    /**
     * @var string|null
     *
     * @ORM\Column(name="photo", type="string", length=50, nullable=true)
     */
    private $photo;

    /**
     * @var \Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="events_departement_id", referencedColumnName="id_department")
     * })
     */
    private $eventsDepartement;

    /**
     * @var \Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="events_region_id", referencedColumnName="id_region")
     * })
     */
    private $eventsRegion;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="created_by_user_id", referencedColumnName="id_user")
     * })
     */
    private $createdByUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Users", mappedBy="eventFk")
     */
    private $eventsUser;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->eventsUser = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdEvent(): ?int
    {
        return $this->idEvent;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNameEvent(): ?string
    {
        return $this->nameEvent;
    }

    public function setNameEvent(string $nameEvent): self
    {
        $this->nameEvent = $nameEvent;

        return $this;
    }

    public function getDescriptionEvent(): ?string
    {
        return $this->descriptionEvent;
    }

    public function setDescriptionEvent(string $descriptionEvent): self
    {
        $this->descriptionEvent = $descriptionEvent;

        return $this;
    }

    public function getPlaceEvent(): ?string
    {
        return $this->placeEvent;
    }

    public function setPlaceEvent(string $placeEvent): self
    {
        $this->placeEvent = $placeEvent;

        return $this;
    }

    public function getDateEvent(): ?\DateTimeInterface
    {
        return $this->dateEvent;
    }

    public function setDateEvent(\DateTimeInterface $dateEvent): self
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    public function getDateCreatedEvent(): ?\DateTimeInterface
    {
        return $this->dateCreatedEvent;
    }

    public function setDateCreatedEvent(\DateTimeInterface $dateCreatedEvent): self
    {
        $this->dateCreatedEvent = $dateCreatedEvent;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getEventsDepartement(): ?Departement
    {
        return $this->eventsDepartement;
    }

    public function setEventsDepartement(?Departement $eventsDepartement): self
    {
        $this->eventsDepartement = $eventsDepartement;

        return $this;
    }

    public function getEventsRegion(): ?Region
    {
        return $this->eventsRegion;
    }

    public function setEventsRegion(?Region $eventsRegion): self
    {
        $this->eventsRegion = $eventsRegion;

        return $this;
    }

    public function getCreatedByUser(): ?Users
    {
        return $this->createdByUser;
    }

    public function setCreatedByUser(?Users $createdByUser): self
    {
        $this->createdByUser = $createdByUser;

        return $this;
    }

    /**
     * @return Collection|Users[]
     */
    public function getEventsUser(): Collection
    {
        return $this->eventsUser;
    }

    public function addEventsUser(Users $eventsUser): self
    {
        if (!$this->eventsUser->contains($eventsUser)) {
            $this->eventsUser[] = $eventsUser;
            $eventsUser->addEventFk($this);
        }

        return $this;
    }

    public function removeEventsUser(Users $eventsUser): self
    {
        if ($this->eventsUser->contains($eventsUser)) {
            $this->eventsUser->removeElement($eventsUser);
            $eventsUser->removeEventFk($this);
        }

        return $this;
    }

}
