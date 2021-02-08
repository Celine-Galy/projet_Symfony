<?php

namespace App\Entity;

use App\Repository\MessageForumRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageForumRepository::class)
 */
class MessageForum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messageForums")
     */
    private $author;

    /**
     * @ORM\OneToMany(targetEntity=ResponseForum::class, mappedBy="initialMessage", orphanRemoval=true)
     */
    private $responseForums;

    /**
     * @ORM\OneToMany(targetEntity=MessageLike::class, mappedBy="messageForum")
     */
    private $messageLikes;


    public function __construct()
    {
        $this->responseForums = new ArrayCollection();
        $this->messageLikes = new ArrayCollection();
    }

  
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(?string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection|ResponseForum[]
     */
    public function getResponseForums(): Collection
    {
        return $this->responseForums;
    }

    public function addResponseForum(ResponseForum $responseForum): self
    {
        if (!$this->responseForums->contains($responseForum)) {
            $this->responseForums[] = $responseForum;
            $responseForum->setInitialMessage($this);
        }

        return $this;
    }

    public function removeResponseForum(ResponseForum $responseForum): self
    {
        if ($this->responseForums->removeElement($responseForum)) {
            // set the owning side to null (unless already changed)
            if ($responseForum->getInitialMessage() === $this) {
                $responseForum->setInitialMessage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessageLike[]
     */
    public function getMessageLikes(): Collection
    {
        return $this->messageLikes;
    }

    public function addMessageLike(MessageLike $messageLike): self
    {
        if (!$this->messageLikes->contains($messageLike)) {
            $this->messageLikes[] = $messageLike;
            $messageLike->setMessageForum($this);
        }

        return $this;
    }

    public function removeMessageLike(MessageLike $messageLike): self
    {
        if ($this->messageLikes->removeElement($messageLike)) {
            // set the owning side to null (unless already changed)
            if ($messageLike->getMessageForum() === $this) {
                $messageLike->setMessageForum(null);
            }
        }

        return $this;
    }

    /**
     * Permet de savoir si ce message est liké par un utilisateur
     *
     * @param User $user
     * @return boolean
     */
    public function isLikedByUser(User $user) : bool 
    {
        foreach($this->messageLikes as $messageLike){
            if($messageLike->getUser() === $user) return true;
        }
        return false;
    }
 
}
