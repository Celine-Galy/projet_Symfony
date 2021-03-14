<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"email"}, message="There is already an account with this email")
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isVerified = false;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="author")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=70)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $avatar;


    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="author", orphanRemoval=true)
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=ArticleLike::class, mappedBy="user")
     */
    private $articleLikes;

    /**
     * @ORM\OneToMany(targetEntity=MessageForum::class, mappedBy="author")
     */
    private $messageForums;

    /**
     * @ORM\OneToMany(targetEntity=ResponseForum::class, mappedBy="author", orphanRemoval=true)
     */
    private $responseForums;

    /**
     * @ORM\OneToMany(targetEntity=ResponseLike::class, mappedBy="user", orphanRemoval=true)
     */
    private $responseLikes;

    /**
     * @ORM\OneToMany(targetEntity=ResponseTo::class, mappedBy="author", orphanRemoval=true)
     */
    private $responseTos;

    /**
     * @ORM\OneToMany(targetEntity=PrivateMessage::class, mappedBy="sender", orphanRemoval=true)
     */
    private $senderPrivateMessages;

    /**
     * @ORM\OneToMany(targetEntity=PrivateMessage::class, mappedBy="recipient", orphanRemoval=true)
     */
    private $recipientPrivateMessages;


    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->comments = new ArrayCollection();
        $this->articleLikes = new ArrayCollection();
        $this->messageForums = new ArrayCollection();
        $this->responseForums = new ArrayCollection();
        $this->responseLikes = new ArrayCollection();
        $this->responseTos = new ArrayCollection();
        $this->senderPrivateMessages = new ArrayCollection();
        $this->recipientPrivateMessages = new ArrayCollection();
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setAuthor($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getAuthor() === $this) {
                $article->setAuthor(null);
            }
        }

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(?string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

 
    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setAuthor($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getAuthor() === $this) {
                $comment->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|ArticleLike[]
     */
    public function getArticleLikes(): Collection
    {
        return $this->articleLikes;
    }

    public function addArticleLike(ArticleLike $articleLike): self
    {
        if (!$this->articleLikes->contains($articleLike)) {
            $this->articleLikes[] = $articleLike;
            $articleLike->setUser($this);
        }

        return $this;
    }

    public function removeArticleLike(ArticleLike $articleLike): self
    {
        if ($this->articleLikes->removeElement($articleLike)) {
            // set the owning side to null (unless already changed)
            if ($articleLike->getUser() === $this) {
                $articleLike->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|MessageForum[]
     */
    public function getMessageForums(): Collection
    {
        return $this->messageForums;
    }

    public function addMessageForum(MessageForum $messageForum): self
    {
        if (!$this->messageForums->contains($messageForum)) {
            $this->messageForums[] = $messageForum;
            $messageForum->setAuthor($this);
        }

        return $this;
    }

    public function removeMessageForum(MessageForum $messageForum): self
    {
        if ($this->messageForums->removeElement($messageForum)) {
            // set the owning side to null (unless already changed)
            if ($messageForum->getAuthor() === $this) {
                $messageForum->setAuthor(null);
            }
        }

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
            $responseForum->setAuthor($this);
        }

        return $this;
    }

    public function removeResponseForum(ResponseForum $responseForum): self
    {
        if ($this->responseForums->removeElement($responseForum)) {
            // set the owning side to null (unless already changed)
            if ($responseForum->getAuthor() === $this) {
                $responseForum->setAuthor(null);
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
            $responseLike->setUser($this);
        }

        return $this;
    }

    public function removeResponseLike(ResponseLike $responseLike): self
    {
        if ($this->responseLikes->removeElement($responseLike)) {
            // set the owning side to null (unless already changed)
            if ($responseLike->getUser() === $this) {
                $responseLike->setUser(null);
            }
        }

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
            $responseTo->setAuthor($this);
        }

        return $this;
    }

    public function removeResponseTo(ResponseTo $responseTo): self
    {
        if ($this->responseTos->removeElement($responseTo)) {
            // set the owning side to null (unless already changed)
            if ($responseTo->getAuthor() === $this) {
                $responseTo->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrivateMessage[]
     */
    public function getSenderPrivateMessages(): Collection
    {
        return $this->senderPrivateMessages;
    }

    public function addSenderPrivateMessage(PrivateMessage $senderPrivateMessage): self
    {
        if (!$this->senderPrivateMessages->contains($senderPrivateMessage)) {
            $this->senderPrivateMessages[] = $senderPrivateMessage;
            $senderPrivateMessage->setSender($this);
        }

        return $this;
    }

    public function removeSenderPrivateMessage(PrivateMessage $senderPrivateMessage): self
    {
        if ($this->senderPrivateMessages->removeElement($senderPrivateMessage)) {
            // set the owning side to null (unless already changed)
            if ($senderPrivateMessage->getSender() === $this) {
                $senderPrivateMessage->setSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PrivateMessage[]
     */
    public function getRecipientPrivateMessages(): Collection
    {
        return $this->recipientPrivateMessages;
    }

    public function addRecipientPrivateMessage(PrivateMessage $recipientPrivateMessage): self
    {
        if (!$this->recipientPrivateMessages->contains($recipientPrivateMessage)) {
            $this->recipientPrivateMessages[] = $recipientPrivateMessage;
            $recipientPrivateMessage->setRecipient($this);
        }

        return $this;
    }

    public function removeRecipientPrivateMessage(PrivateMessage $recipientPrivateMessage): self
    {
        if ($this->recipientPrivateMessages->removeElement($recipientPrivateMessage)) {
            // set the owning side to null (unless already changed)
            if ($recipientPrivateMessage->getRecipient() === $this) {
                $recipientPrivateMessage->setRecipient(null);
            }
        }

        return $this;
    }


}
