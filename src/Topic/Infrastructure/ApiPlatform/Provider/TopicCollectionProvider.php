<?php

namespace App\Topic\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Topic\Domain\Repository\TopicRepository;
use App\Topic\Infrastructure\ApiPlatform\Resource\TopicResource;
use \ApiPlatform\Metadata\Operation;

class TopicCollectionProvider implements ProviderInterface
{
    public function __construct(private TopicRepository $repo) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $topics = $this->repo->findAll();

        $result = [];

        foreach ($topics as $topic) {
            $resource = new TopicResource();
            $resource->id = $topic->getId();
            $resource->title = $topic->getTitle();

            $result[] = $resource;
        }

        return $result;
    }
}
