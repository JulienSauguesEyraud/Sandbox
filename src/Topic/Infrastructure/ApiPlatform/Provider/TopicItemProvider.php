<?php

namespace App\Topic\Infrastructure\ApiPlatform\Provider;

use ApiPlatform\State\ProviderInterface;
use App\Topic\Domain\Repository\TopicRepository;
use App\Topic\Infrastructure\ApiPlatform\Resource\TopicResource;
use \ApiPlatform\Metadata\Operation;

class TopicItemProvider implements ProviderInterface
{
    public function __construct(private TopicRepository $repo) {}

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): object|array|null
    {
        $topic = $this->repo->find($uriVariables['id']);

        $resource = new TopicResource();
        $resource->id = $topic->getId();
        $resource->title = $topic->getTitle();

        return $resource;
    }
}
