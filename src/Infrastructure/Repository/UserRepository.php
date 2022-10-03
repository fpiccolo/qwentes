<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use App\Domain\Entity\UserAddress;
use App\Domain\Repository\UserRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;

class UserRepository implements UserRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);

        $this->entityManager->flush();
    }

    public function getByUsernameAndPassword(string $email, string $password): ?User
    {
        $repository = $this->entityManager->getRepository(User::class);

        $user = $repository->findOneBy([
            'email' => $email,
            'password'=> $password
        ]);

        return $user;
    }

    /**
     * @return array{User[], int, int}
     */
    public function searchUser(int $page, int $itemPerPage, array $emails, array $countryCodes, array $sorts): array
    {
        $repository = $this->entityManager->getRepository(User::class);

        $queryBuilder = $repository
            ->createQueryBuilder('u')
            ->leftJoin('u.address', 'a');

        foreach ($sorts as $sort){
            $sortField = substr($sort, 1);
            $sortDir = str_replace($sortField, '', $sort) == '+' ? 'ASC' : 'DESC';
            $queryBuilder->addOrderBy('u.'.$sortField, $sortDir);
        }
        if(0 !== count($emails)){
            $queryBuilder->andWhere('u.email IN (:emails)')
                ->setParameter('emails', $emails);
        }

        if(0 !== count($countryCodes)){
            $queryBuilder->andWhere('a.countryCode IN (:countries)')
                ->setParameter('countries', $countryCodes);
        }




        $query = $queryBuilder
            ->getQuery();

        $paginator = new Paginator($query);

        $totalItems = count($paginator);

        $pagesCount = ceil($totalItems/$itemPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemPerPage * ($page-1))
            ->setMaxResults($itemPerPage);

        $users = [];

        foreach ($paginator as $item) {
            $users[] = $item;
        }

        return [$users, $totalItems, (int) $pagesCount];
    }

    public function findUserByEmail(string $email): ?User
    {
        $repository = $this->entityManager->getRepository(User::class);

        return $repository->findOneBy(['email' => $email]);
    }
}