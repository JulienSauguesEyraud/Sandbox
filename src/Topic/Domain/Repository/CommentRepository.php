<?php

namespace App\Topic\Domain\Repository;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
class CommentRepository extends ServiceEntityRepository
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

    public function findChildren(Comment $comment): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.parent = :parent')
            ->setParameter('parent', $comment)
            ->getQuery()
            ->getResult();
    }

//    /**
//     * @return Comment[] Returns an array of Comment objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Comment
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
