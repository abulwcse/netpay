<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FilesystemRepository")
 */
class Filesystem
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Filesystem", inversedBy="parent_id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Filesystem", mappedBy="parent")
     */
    private $parent_id;

    public function __construct()
    {
        $this->parent_id = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = trim($title);

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParentId(): Collection
    {
        return $this->parent_id;
    }

    public function addParentId(self $parentId): self
    {
        if (!$this->parent_id->contains($parentId)) {
            $this->parent_id[] = $parentId;
            $parentId->setParent($this);
        }

        return $this;
    }

    public function removeParentId(self $parentId): self
    {
        if ($this->parent_id->contains($parentId)) {
            $this->parent_id->removeElement($parentId);
            // set the owning side to null (unless already changed)
            if ($parentId->getParent() === $this) {
                $parentId->setParent(null);
            }
        }

        return $this;
    }
}
