<?php

namespace App\Topic\Domain\Repository;

use App\Topic\Domain\Entity\Comment;
use App\Topic\Domain\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Comment>
 */
interface CommentRepository
{
    /** @return Comment|null */
    public function find(mixed $id): object|null;

    /** @return Comment[] */
    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array;

    /** @return Comment|null */
    public function findOneBy(array $criteria, array|null $orderBy = null): object|null;

    public function findRootByTopic(Topic $topic): array;
}
