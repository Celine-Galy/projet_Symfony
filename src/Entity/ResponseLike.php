<?php

namespace App\Entity;

use App\Repository\ResponseLikeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ResponseLikeRepository::class)
 */
class ResponseLike
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=ResponseForum::class, inversedBy="responseLikes")
     */
    private $responseForum;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="responseLikes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getResponseForum(): ?ResponseForum
    {
        return $this->responseForum;
    }

    public function setResponseForum(?ResponseForum $responseForum): self
    {
        $this->responseForum = $responseForum;

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
