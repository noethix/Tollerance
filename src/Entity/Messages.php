<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Messages
 *
 * @ORM\Table(name="messages", indexes={@ORM\Index(name="Messages_Users_FK", columns={"id_user"})})
 * @ORM\Entity
 */
class Messages
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_message", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="subject_message", type="string", length=50, nullable=false)
     */
    private $subjectMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="content_message", type="text", length=65535, nullable=false)
     */
    private $contentMessage;

    /**
     * @var string
     *
     * @ORM\Column(name="type_message", type="string", length=10, nullable=false, options={"default"="user","comment"="'user' => Message privé entre utilisateurs     'admin' => Message privé entre utilisateur et administrateur 'moderateur' => Message privé entre utilisateurs et moderateur"})
     */
    private $typeMessage = 'user';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_message", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDateMessage = 'CURRENT_TIMESTAMP';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user_recipient", referencedColumnName="id_user")
     * })
     */
     
    private $idUserRecipient;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    public function getIdMessage(): ?int
    {
        return $this->idMessage;
    }

    public function getSubjectMessage(): ?string
    {
        return $this->subjectMessage;
    }

    public function setSubjectMessage(string $subjectMessage): self
    {
        $this->subjectMessage = $subjectMessage;

        return $this;
    }

    public function getContentMessage(): ?string
    {
        return $this->contentMessage;
    }

    public function setContentMessage(string $contentMessage): self
    {
        $this->contentMessage = $contentMessage;

        return $this;
    }

    public function getTypeMessage(): ?string
    {
        return $this->typeMessage;
    }

    public function setTypeMessage(string $typeMessage): self
    {
        $this->typeMessage = $typeMessage;

        return $this;
    }

    public function getCreatedDateMessage(): ?\DateTimeInterface
    {
        return $this->createdDateMessage;
    }

    public function setCreatedDateMessage(\DateTimeInterface $createdDateMessage): self
    {
        $this->createdDateMessage = $createdDateMessage;

        return $this;
    }

    public function getIdUserRecipient(): ?Users
    {
        return $this->idUserRecipient;
    }

    public function setIdUserRecipient(?Users $idUserRecipient): self
    {
        $this->idUserRecipient = $idUserRecipient;

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
