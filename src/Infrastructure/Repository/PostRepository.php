<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Post;
use App\Domain\Entity\PostTag;
use App\Domain\Repository\PostRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Query\ResultSetMapping;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Ramsey\Uuid\UuidInterface;
use function Doctrine\ORM\QueryBuilder;

class PostRepository implements PostRepositoryInterface
{
    private EntityManagerInterface $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->entityManager = $entityManager;
    }

    public function save(Post $post)
    {
        $this->entityManager->persist($post);
        $this->entityManager->flush();
    }

    public function get(UuidInterface $id): ?Post
    {
        $repository = $this->entityManager->getRepository(Post::class);

        return $repository->find($id);
    }

    public function search(int $page, int $itemPerPage, string $q, array $tags): array
    {


        $repository = $this->entityManager->getRepository(Post::class);

        $queryBuilder = $repository
            ->createQueryBuilder('u')
            ->leftJoin('u.tags', 't');


        if (!empty($q)) {

            $queryBuilder->andWhere($queryBuilder->expr()->orX(
                $queryBuilder->expr()->like('u.title', ':title'),
                $queryBuilder->expr()->like('u.body', ':body'),
            ))
                ->setParameter('title', "%$q%")
                ->setParameter('body', "%$q%");

        }

        if (!empty($tags)) {
            $queryBuilder->andWhere('t.tag IN (:tags)')
                ->setParameter('tags', $tags);
        }


        $query = $queryBuilder
            ->getQuery();


        $paginator = new Paginator($query);

        $totalItems = count($paginator);

        $pagesCount = ceil($totalItems / $itemPerPage);

        $paginator
            ->getQuery()
            ->setFirstResult($itemPerPage * ($page - 1))
            ->setMaxResults($itemPerPage);

        $posts = [];

        foreach ($paginator->getIterator() as $item) {
            $posts[] = $item;
        }

        return [$posts, $totalItems, (int)$pagesCount];
    }
}