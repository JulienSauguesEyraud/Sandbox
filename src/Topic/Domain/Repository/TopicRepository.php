<?php

namespace App\Topic\Domain\Repository;

use App\Topic\Domain\Entity\Topic;

interface TopicRepository
{
    /** @return Topic|null */
    public function find(mixed $id): object|null;

    /** @return Topic[] */
    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array;

    /** @return Topic|null */
    public function findOneBy(array $criteria, array|null $orderBy = null): object|null;
}
