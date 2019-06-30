<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Table(name="posts", indexes={@ORM\Index(name="id_groupe", columns={"id_groupe"}), @ORM\Index(name="Posts_Users0_FK", columns={"posts_user_id"}), @ORM\Index(name="id_topic", columns={"id_topic"}), @ORM\Index(name="id_activite", columns={"id_activite"}), @ORM\Index(name="Posts_Topics_FK", columns={"id_event"})})
 * @ORM\Entity
 */
class Posts
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_post", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPost;

    /**
     * @var string
     *
     * @ORM\Column(name="content_post", type="text", length=65535, nullable=false)
     */
    private $contentPost;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_date_post", type="datetime", nullable=false, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $createdDatePost = 'CURRENT_TIMESTAMP';

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="posts_user_id", referencedColumnName="id_user")
     * })
     */
    private $postsUser;

    /**
     * @var \Activites
     *
     * @ORM\ManyToOne(targetEntity="Activites")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_activite", referencedColumnName="id_activites")
     * })
     */
    private $idActivite;

    /**
     * @var \Groupes
     *
     * @ORM\ManyToOne(targetEntity="Groupes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_groupe", referencedColumnName="id_groupe")
     * })
     */
    private $idGroupe;

    /**
     * @var \Events
     *
     * @ORM\ManyToOne(targetEntity="Events")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_event", referencedColumnName="id_event")
     * })
     */
    private $idEvent;

    /**
     * @var \Topics
     *
     * @ORM\ManyToOne(targetEntity="Topics")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_topic", referencedColumnName="id_topic")
     * })
     */
    private $idTopic;

    public function getIdPost(): ?int
    {
        return $this->idPost;
    }

    public function getContentPost(): ?string
    {
        return $this->contentPost;
    }

    public function setContentPost(string $contentPost): self
    {
        $this->contentPost = $contentPost;

        return $this;
    }

    public function getCreatedDatePost(): ?\DateTimeInterface
    {
        return $this->createdDatePost;
    }

    public function setCreatedDatePost(\DateTimeInterface $createdDatePost): self
    {
        $this->createdDatePost = $createdDatePost;

        return $this;
    }

    public function getPostsUser(): ?Users
    {
        return $this->postsUser;
    }

    public function setPostsUser(?Users $postsUser): self
    {
        $this->postsUser = $postsUser;

        return $this;
    }

    public function getIdActivite(): ?Activites
    {
        return $this->idActivite;
    }

    public function setIdActivite(?Activites $idActivite): self
    {
        $this->idActivite = $idActivite;

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

    public function getIdEvent(): ?Events
    {
        return $this->idEvent;
    }

    public function setIdEvent(?Events $idEvent): self
    {
        $this->idEvent = $idEvent;

        return $this;
    }

    public function getIdTopic(): ?Topics
    {
        return $this->idTopic;
    }

    public function setIdTopic(?Topics $idTopic): self
    {
        $this->idTopic = $idTopic;

        return $this;
    }


}
