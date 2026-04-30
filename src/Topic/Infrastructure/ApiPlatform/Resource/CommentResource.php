<?php

namespace App\Topic\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use App\Topic\Infrastructure\ApiPlatform\Provider\CommentProvider;
use App\Topic\Infrastructure\ApiPlatform\Provider\CommentTreeProvider;

#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: '/comments',
            provider: CommentProvider::class
        ),
        new Get(
            uriTemplate: '/comments/{id}',
            provider: CommentTreeProvider::class
        )
    ]
)]
class CommentResource
{
    public int $id;
    public string $description;
    public TopicResource $topic;
    public ?CommentResource $parent;

    /* @var CommentResource[] */
    public array $children;
}
