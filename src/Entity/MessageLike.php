<?php

namespace App\Entity;

use App\Repository\MessageLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessageLikeRepository::class)
 */
class MessageLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=MessageForum::class, inversedBy="messageLikes")
     */
    private $messageForum;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messageLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessageForum(): ?MessageForum
    {
        return $this->messageForum;
    }

    public function setMessageForum(?MessageForum $messageForum): self
    {
        $this->messageForum = $messageForum;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
