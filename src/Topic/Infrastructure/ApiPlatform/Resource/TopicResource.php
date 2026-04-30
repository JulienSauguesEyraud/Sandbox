<?php

namespace App\Topic\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Topic\Infrastructure\ApiPlatform\Provider\TopicCollectionProvider;
use App\Topic\Infrastructure\ApiPlatform\Provider\TopicItemProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/topics',
            provider: TopicCollectionProvider::class
        ),
        new Get(
            uriTemplate: '/topics/{id}',
            provider: TopicItemProvider::class
        )
    ]
)]
class TopicResource
{
    public int $id;
    public string $title;
}
