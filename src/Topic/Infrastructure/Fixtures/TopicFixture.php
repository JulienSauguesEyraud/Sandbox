<?php

namespace App\Topic\Infrastructure\Fixtures;

use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;
use Orbitale\Component\ArrayFixture\ArrayFixture;

class TopicFixture extends ArrayFixture implements ORMFixtureInterface
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('en_US');
    }
    public function getEntityClass(): string
    {
        return Topic::class;
    }

    public function getReferencePrefix(): ?string
    {
        return 'topic_';
    }

    public function getObjects(): iterable
    {
        yield ['id' => 1, 'title' => $this->faker->bs()];
        yield ['id' => 2, 'title' => $this->faker->bs()];
        yield ['id' => 3, 'title' => $this->faker->bs()];
        yield ['id' => 4, 'title' => $this->faker->bs()];
        yield ['id' => 5, 'title' => $this->faker->bs()];
    }
}
