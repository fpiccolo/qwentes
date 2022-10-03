<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Output\PostOutput;
use App\Application\Exception\PostNotFondException;
use App\Domain\Repository\PostRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

class GetPostManager
{
    private PostRepositoryInterface $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public function getPost(UuidInterface $id): PostOutput
    {
        $post = $this->postRepository->get($id);

        if(null === $post){
            throw new PostNotFondException($id);
        }

        return new PostOutput($post);
    }
}