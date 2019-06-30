<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Topics
 *
 * @ORM\Table(name="topics", indexes={@ORM\Index(name="Topics_Users0_FK", columns={"id_user"}), @ORM\Index(name="Topics_Forums_FK", columns={"id_groupe"})})
 * @ORM\Entity
 */
class Topics
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_topic", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idTopic;

    /**
     * @var string
     *
     * @ORM\Column(name="name_topic", type="string", length=50, nullable=false)
     */
    private $nameTopic;

    /**
     * @var string
     *
     * @ORM\Column(name="content_topic", type="text", length=65535, nullable=false)
     */
    private $contentTopic;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_topic", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDateTopic = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_post_date", type="datetime", nullable=false)
     */
    private $lastPostDate;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Groupes
     *
     * @ORM\ManyToOne(targetEntity="Groupes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_groupe", referencedColumnName="id_groupe")
     * })
     */
    private $idGroupe;

    public function getIdTopic(): ?int
    {
        return $this->idTopic;
    }

    public function getNameTopic(): ?string
    {
        return $this->nameTopic;
    }

    public function setNameTopic(string $nameTopic): self
    {
        $this->nameTopic = $nameTopic;

        return $this;
    }

    public function getContentTopic(): ?string
    {
        return $this->contentTopic;
    }

    public function setContentTopic(string $contentTopic): self
    {
        $this->contentTopic = $contentTopic;

        return $this;
    }

    public function getCreatedDateTopic(): ?\DateTimeInterface
    {
        return $this->createdDateTopic;
    }

    public function setCreatedDateTopic(\DateTimeInterface $createdDateTopic): self
    {
        $this->createdDateTopic = $createdDateTopic;

        return $this;
    }

    public function getLastPostDate(): ?\DateTimeInterface
    {
        return $this->lastPostDate;
    }

    public function setLastPostDate(\DateTimeInterface $lastPostDate): self
    {
        $this->lastPostDate = $lastPostDate;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdGroupe(): ?Groupes
    {
        return $this->idGroupe;
    }

    public function setIdGroupe(?Groupes $idGroupe): self
    {
        $this->idGroupe = $idGroupe;

        return $this;
    }


}
