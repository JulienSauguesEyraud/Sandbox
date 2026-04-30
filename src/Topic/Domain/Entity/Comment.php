<?php

namespace App\Topic\Domain\Entity;

use App\Topic\Infrastructure\Repository\DoctrineCommentRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DoctrineCommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'text')]
    private ?string $description = null;

    #[ORM\ManyToOne]
    private ?Comment $parent = null;

    #[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'parent')]
    private Collection $children;

    #[ORM\ManyToOne(targetEntity: Topic::class, inversedBy: 'comments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Topic $topic = null;

    public function getParent()
    {
        return $this->parent;
    }

    public function getTopic(): ?Topic
    {
        return $this->topic;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getChildren(): Collection
    {
        return $this->children;
    }
}
