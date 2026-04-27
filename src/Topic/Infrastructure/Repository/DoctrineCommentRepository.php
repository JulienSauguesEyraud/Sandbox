<?php

namespace App\Topic\Infrastructure\Repository;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use App\Topic\Domain\Repository\CommentRepository;
use App\Topic\Domain\Repository\TopicRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class DoctrineCommentRepository extends ServiceEntityRepository implements CommentRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comment::class);
    }

    public function findRootByTopic(Topic $topic): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.topic = :topic')
            ->andWhere('c.parent IS NULL')
            ->setParameter('topic', $topic)
            ->getQuery()
            ->getResult();
    }
}
