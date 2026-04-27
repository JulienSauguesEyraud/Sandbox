<?php

namespace App\Topic\Infrastructure\Fixtures;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;
use Orbitale\Component\ArrayFixture\ArrayFixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CommentFixture extends ArrayFixture implements DependentFixtureInterface, ORMFixtureInterface
{
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

    public function getMethodNameForReference(): string
    {
        return 'getName';
    }

    public function getObjects(): iterable
    {
        $texts = [
            'Lorem ipsum dolor sit amet',
            'Consectetur adipiscing elit',
            'Fusce quis sodales nibh',
            'Pellentesque dapibus massa cursus',
            'Sed ut perspiciatis',
            'Etiam sodales sed felis a aliquet',
            'In hac habitasse platea dictumst',
            'Sed ut perspiciatis',
            'Sed vitae lobortis leo',
            'Sed accumsan purus quis sem venenatis'
        ];

        $refs = [];

        for ($i = 1; $i <= 5; $i++) {

            $ref = "comment_c_$i";
            $refs[] = $ref;

            yield [
                'name' => 'c_'. $i,
                'description' => $texts[$i - 1],
                'topic' => $this->getReference('topic_t' . ($i - 1), Topic::class),
                'parent' => null,
            ];
        }

        for ($i = 6; $i <= 500; $i++) {

            $ref = "comment_c_child_$i";

            $parent = null;

            if (random_int(0, 20) !== 0 && !empty($refs)) {
                $parent = $this->getReference(
                    $refs[array_rand($refs)],
                    Comment::class
                );
            }

            yield [
                'name' => 'c_child_' . $i,
                'description' => $texts[random_int(0, count($texts) - 1)],

                'parent' => $parent,

                'topic' => $parent
                    ? function (Comment $comment) {
                        return $comment->getParent()->getTopic();
                    }
                    : $this->getReference('topic_t' . random_int(0, 4), Topic::class),
            ];

            $refs[] = $ref;
        }
    }
}
