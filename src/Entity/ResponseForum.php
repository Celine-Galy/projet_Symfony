<?php

namespace App\Entity;

use App\Entity\User;
use App\Entity\MessageForum;
use App\Entity\ResponseLike;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ResponseForumRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass=ResponseForumRepository::class)
 */
class ResponseForum
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responseForums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=MessageForum::class, inversedBy="responseForums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $initialMessage;

    /**
     * @ORM\OneToMany(targetEntity=ResponseTo::class, mappedBy="responseForum", cascade={"remove"})
     */
    private $responseTos;


    /**
     * @ORM\OneToMany(targetEntity=ResponseLike::class, mappedBy="responseForum",cascade={"remove"})
     */
    private $responseLikes;

    public function __construct()
    {
        $this->responseLikes = new ArrayCollection();
        $this->responseTos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getInitialMessage(): ?MessageForum
    {
        return $this->initialMessage;
    }

    public function setInitialMessage(?MessageForum $initialMessage): self
    {
        $this->initialMessage = $initialMessage;

        return $this;
    }

    /**
     * @return Collection|ResponseTo[]
     */
    public function getResponseTos(): Collection
    {
        return $this->responseTos;
    }

    public function addResponseTo(ResponseTo $responseTo): self
    {
        if (!$this->responseTos->contains($responseTo)) {
            $this->responseTos[] = $responseTo;
            $responseTo->setResponseForum($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ResponseLike[]
     */
    public function getResponseLikes(): Collection
    {
        return $this->responseLikes;
    }

    public function addResponseLike(ResponseLike $responseLike): self
    {
        if (!$this->responseLikes->contains($responseLike)) {
            $this->responseLikes[] = $responseLike;
            $responseLike->setResponseForum($this);
        }

        return $this;
    }

    public function removeResponseLike(ResponseLike $responseLike): self
    {
        if ($this->responseLikes->removeElement($responseLike)) {
            // set the owning side to null (unless already changed)
            if ($responseLike->getResponseForum() === $this) {
                $responseLike->setResponseForum(null);
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
        foreach($this->responseLikes as $responseLike){
            if($responseLike->getUser() === $user) return true;
        }
        return false;
    }
 
}
