<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\PostInput;
use App\Application\DTO\Output\PostOutput;
use App\Domain\Entity\Post;
use App\Domain\Entity\PostTag;
use App\Domain\Repository\PostRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;

class CreatePostManager
{
    private PostRepositoryInterface $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public function createPost(PostInput $postInput): PostOutput
    {
        foreach ($postInput->tags as $tag) {
            $tags[] = new PostTag(
                Uuid::uuid4(),
                $tag
            );
        }

        $post = new Post(
            Uuid::uuid4(),
            $postInput->title,
            $postInput->body,
            $postInput->status,
        );

        foreach ($postInput->tags as $tag) {
            $post->addTag(
                new PostTag(
                    Uuid::uuid4(),
                    $tag
                )
            );
        }

        $this->postRepository->save($post);

        return new PostOutput($post);

    }
}