<?php

namespace App\Topic\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Repository\CommentRepository;
use App\Topic\Infrastructure\ApiPlatform\Resource\CommentResource;
use App\Topic\Infrastructure\ApiPlatform\Resource\TopicResource;
use \ApiPlatform\Metadata\Operation;

class CommentTreeProvider implements ProviderInterface
{
    public function __construct(private CommentRepository $repo) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $comment = $this->repo->find($uriVariables['id']);

        return $this->createTree($comment);
    }

    private function createTree(Comment $comment): CommentResource
    {
        $resource = new CommentResource();
        $resource->id = $comment->getId();
        $resource->description = $comment->getDescription();

        $topicResource = new TopicResource();
        $topicResource->id = $comment->getTopic()->getId();
        $topicResource->title = $comment->getTopic()->getTitle();
        $resource->topic = $topicResource;

        $children = [];
        foreach ($comment->getChildren() as $child) {
            $children[] = $this->createTree($child);
        }
        $resource->children = $children;

        return $resource;
    }
}
