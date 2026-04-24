<?php

namespace App\Topic\Domain\Entity;

use App\Topic\Domain\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    private ?comment $parent = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
