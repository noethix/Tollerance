<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Forums
 *
 * @ORM\Table(name="forums", indexes={@ORM\Index(name="Forums_Community_FK", columns={"id_community"}), @ORM\Index(name="Forums_Users0_FK", columns={"id_user"})})
 * @ORM\Entity
 */
class Forums
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_forum", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idForum;

    /**
     * @var string
     *
     * @ORM\Column(name="name_forum", type="string", length=50, nullable=false)
     */
    private $nameForum;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_forum", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDateForum = 'CURRENT_TIMESTAMP';

    /**
     * @var \Community
     *
     * @ORM\ManyToOne(targetEntity="Community")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_community", referencedColumnName="id_community")
     * })
     */
    private $idCommunity;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdForum(): ?int
    {
        return $this->idForum;
    }

    public function getNameForum(): ?string
    {
        return $this->nameForum;
    }

    public function setNameForum(string $nameForum): self
    {
        $this->nameForum = $nameForum;

        return $this;
    }

    public function getCreatedDateForum(): ?\DateTimeInterface
    {
        return $this->createdDateForum;
    }

    public function setCreatedDateForum(\DateTimeInterface $createdDateForum): self
    {
        $this->createdDateForum = $createdDateForum;

        return $this;
    }

    public function getIdCommunity(): ?Community
    {
        return $this->idCommunity;
    }

    public function setIdCommunity(?Community $idCommunity): self
    {
        $this->idCommunity = $idCommunity;

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


}
