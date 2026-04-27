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
        yield ['name' => 't0', 'title' => 'Lorem ipsum dolor sit amet'];
        yield ['name' => 't1', 'title' => 'Consectetur adipiscing elit'];
        yield ['name' => 't2', 'title' => 'Fusce quis sodales nibh'];
        yield ['name' => 't3', 'title' => 'Pellentesque dapibus massa cursus'];
        yield ['name' => 't4', 'title' => 'Sed ut perspiciatis'];
    }
}
