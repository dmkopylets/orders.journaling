<?php

namespace App\Entity;

use App\Repository\DictBranchRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DictBranchRepository::class)]
#[ORM\Table(name: "dict_branches")]
class DictBranch
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column(length: 255)]
    private ?string $body = null;

    #[ORM\Column(length: 10)]
    private string $prefix;

    #[ORM\OneToMany(targetEntity: DictAdjuster::class, mappedBy: 'branch', orphanRemoval: true)]
    private Collection $adjusters;

    public function __construct()
    {
        $this->adjusters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): static
    {
        $this->body = $body;

        return $this;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }
    public function setPrefix(string $prefix): static
    {
        $this->prefix = $prefix;

        return $this;
    }

    public function geAdjusters(): Collection
    {
        return $this->adjusters;
    }

    public function addBook(DictAdjuster $adjuster): static
    {
        if (!$this->adjusters->contains($adjuster)) {
            $this->adjusters->add($adjuster);
            $adjuster->setBranch($this);
        }

        return $this;
    }

    public function removeBook(DictAdjuster $adjuster): static
    {
        if ($this->adjusters->removeElement($adjuster)) {
            if ($adjuster->getBranch() === $this) {
                $adjuster->setBranch(null);
            }
        }

        return $this;
    }
}
