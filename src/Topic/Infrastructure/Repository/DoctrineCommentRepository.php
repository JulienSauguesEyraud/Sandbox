<?php

namespace App\Topic\Infrastructure\Repository;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Repository\CommentRepository;
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

    public function findRootByTopic(int|string $topicId): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.topic = :topicId')
            ->andWhere('c.parent IS NULL')
            ->setParameter('topicId', $topicId)
            ->getQuery()
            ->getResult();
    }
}
