<?php

namespace App\Topic\Infrastructure\Fixtures;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Faker\Factory;
use Faker\Generator;
use Orbitale\Component\ArrayFixture\ArrayFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixture extends ArrayFixture implements DependentFixtureInterface, ORMFixtureInterface
{
    private Generator $faker;
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }
    public function getEntityClass(): string
    {
        return Comment::class;
    }

    public function getDependencies(): array
    {
        return [TopicFixture::class];
    }

    public function getReferencePrefix(): ?string
    {
        return 'comment_';
    }

    public function getObjects(): iterable
    {
        $refs = [];

        for ($i = 1; $i <= 5; $i++) {

            $ref = "comment_$i";
            $refs[] = $ref;

            yield [
                'id' => $i,
                'description' => $this->faker->realTextBetween(100, 3000),
                'topic' => $this->getReference('topic_' . $i, Topic::class),
                'parent' => null,
            ];
        }

        for ($i = 6; $i <= 500; $i++) {

            $ref = "comment_$i";

            $parent = null;

            if (random_int(0, 20) !== 0 && !empty($refs)) {
                $parent = $this->getReference(
                    $refs[array_rand($refs)],
                    Comment::class
                );
            }

            yield [
                'id' => $i,
                'description' => $this->faker->realTextBetween(100, 3000),

                'parent' => $parent,

                'topic' => $parent
                    ? function (Comment $comment) {
                        return $comment->getParent()->getTopic();
                    }
                    : $this->getReference('topic_' . random_int(1, 5), Topic::class),
            ];

            $refs[] = $ref;
        }
    }
}
