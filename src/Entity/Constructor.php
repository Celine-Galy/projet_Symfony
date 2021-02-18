<?php

namespace App\Entity;

use App\Repository\ConstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ConstructorRepository::class)
 */
class Constructor
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cover;

    /**
     * @ORM\OneToMany(targetEntity=Console::class, mappedBy="constructor")
     */
    private $consoles;

    public function __construct()
    {
        $this->consoles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCover(): ?string
    {
        return $this->cover;
    }

    public function setCover(?string $cover): self
    {
        $this->cover = $cover;

        return $this;
    }
    

    /**
     * @return Collection|Console[]
     */
    public function getConsoles(): Collection
    {
        return $this->consoles;
    }

    public function addConsole(Console $console): self
    {
        if (!$this->consoles->contains($console)) {
            $this->consoles[] = $console;
            $console->setConstructor($this);
        }

        return $this;
    }

    public function removeConsole(Console $console): self
    {
        if ($this->consoles->removeElement($console)) {
            // set the owning side to null (unless already changed)
            if ($console->getConstructor() === $this) {
                $console->setConstructor(null);
            }
        }

        return $this;
    }

}
