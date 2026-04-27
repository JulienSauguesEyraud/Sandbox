<?php

namespace App\Topic\Infrastructure\Repository;

use App\Topic\Domain\Entity\Topic;
use App\Topic\Domain\Repository\TopicRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Topic>
 */
class DoctrineTopicRepository extends ServiceEntityRepository implements TopicRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }
}
