<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Game::class, inversedBy="messages")
     */
    private $game;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\ManyToOne(targetEntity=Subject::class, inversedBy="messages", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $subject;

    /**
     * @ORM\OneToMany(targetEntity=MessageLike::class, mappedBy="message")
     */
    private $messageLikes;

    public function __construct()
    {
        $this->messageLikes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    public function setAuthor(?User $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getSubject(): ?Subject
    {
        return $this->subject;
    }

    public function setSubject(?Subject $subject): self
    {
        $this->subject = $subject;

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
            $messageLike->setMessage($this);
        }

        return $this;
    }

    public function removeMessageLike(MessageLike $messageLike): self
    {
        if ($this->messageLikes->removeElement($messageLike)) {
            // set the owning side to null (unless already changed)
            if ($messageLike->getMessage() === $this) {
                $messageLike->setMessage(null);
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
