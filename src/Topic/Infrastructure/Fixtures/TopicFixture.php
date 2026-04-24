<?php

namespace App\Topic\Infrastructure\Fixtures;

use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class TopicFixture extends ArrayFixture implements ORMFixtureInterface
{
    public function getEntityClass(): string
    {
        return Topic::class;
    }

    public function getReferencePrefix(): ?string
    {
        return 'topic_';
    }

    public function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getObjects(): iterable
    {
        yield ['name' => 't0'];
        yield ['name' => 't1'];
        yield ['name' => 't2'];
        yield ['name' => 't3'];
        yield ['name' => 't4'];
    }
}
