<?php

namespace App\User\Domain\Repository;

use App\Topic\Domain\Entity\Topic;
use App\User\Domain\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;

/**
 * @extends ServiceEntityRepository<User>
 */
interface UserRepository
{
    /** @return User|null */
    public function find(mixed $id): object|null;

    /** @return User[] */
    public function findBy(array $criteria, array|null $orderBy = null, int|null $limit = null, int|null $offset = null): array;

    /** @return User|null */
    public function findOneBy(array $criteria, array|null $orderBy = null): object|null;

    public function upgradePassword(PasswordAuthenticatedUserInterface $user, string $newHashedPassword): void;

    public function saveUser(User $user): User;
}
