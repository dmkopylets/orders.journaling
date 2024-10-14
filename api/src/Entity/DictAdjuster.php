<?php

namespace App\Entity;

use App\Repository\DictAdjusterRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: DictAdjusterRepository::class)]
#[ORM\Table(name: "dict_adjusters")]
class DictAdjuster
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[ORM\Column]
    private ?int $branch_id = null;

    #[ORM\Column(length: 255)]
    private ?string $body = null;

    #[ORM\Column(length: 255)]
    private ?string $in_group = null;

    #[ORM\ManyToOne(targetEntity: DictBranch::class, inversedBy: 'adjusters')]
    #[Groups(['adjuster:list', 'adjuster:list:write'])]
    private DictBranch $branch;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBranch(): ?DictBranch
    {
        return $this->branch;
    }

    public function setBranch(?DictBranch $branch): self
    {
        $this->branch = $branch;

        return $this;
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

    public function getInGroup(): ?string
    {
        return $this->in_group;
    }

    public function setInGroup(string $in_group): static
    {
        $this->in_group = $in_group;

        return $this;
    }
}
