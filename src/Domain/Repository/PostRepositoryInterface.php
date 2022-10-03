<?php
declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Post;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

interface PostRepositoryInterface
{
    public function save(Post $post);

    public function get(UuidInterface $id): ?Post;
}