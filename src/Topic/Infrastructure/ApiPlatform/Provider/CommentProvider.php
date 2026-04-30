<?php

namespace App\Topic\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Topic\Domain\Repository\CommentRepository;
use App\Topic\Domain\Repository\TopicRepository;
use App\Topic\Infrastructure\ApiPlatform\Resource\CommentResource;
use App\Topic\Infrastructure\ApiPlatform\Resource\TopicResource;
use \ApiPlatform\Metadata\Operation;

class CommentProvider implements ProviderInterface
{
    public function __construct(private CommentRepository $repo) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $comments = $this->repo->findAll();

        $result = [];

        foreach ($comments as $comment) {
            $resource = new CommentResource();
            $resource->id = $comment->getId();
            $resource->description = $comment->getDescription();

            $topicResource = new TopicResource();
            $topicResource->id = $comment->getTopic()->getId();
            $topicResource->title = $comment->getTopic()->getTitle();
            $resource->topic = $topicResource;

            if($comment->getParent()){
                $parentResource = new CommentResource();
                $parentResource->id = $comment->getParent()->getId();
                $parentResource->description = $comment->getParent()->getDescription();
                $parentResource->topic = $topicResource;

                $resource->parent = $parentResource;
            }

            $result[] = $resource;
        }

        return $result;
    }
}
