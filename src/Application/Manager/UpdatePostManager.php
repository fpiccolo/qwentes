<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\PostInput;
use App\Application\DTO\Output\PostOutput;
use App\Application\Exception\PostNotFondException;
use App\Domain\Entity\PostTag;
use App\Domain\Repository\PostRepositoryInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class UpdatePostManager
{
    private PostRepositoryInterface $postRepository;

    public function __construct(
        PostRepositoryInterface $postRepository
    )
    {
        $this->postRepository = $postRepository;
    }

    public function updatePost(UuidInterface $id, PostInput $postInput): PostOutput
    {
        $post = $this->postRepository->get($id);

        if(null === $post){
            throw new PostNotFondException($id);
        }

        $post->setTitle($postInput->title);
        $post->setBody($postInput->body);
        $post->setStatus($postInput->status);

        $tags = new ArrayCollection();
        foreach ($postInput->tags as $tag){
            $tags[] = new PostTag(
                Uuid::uuid4(),
                $tag
            );
        }
        $post->setTags($tags);

        $this->postRepository->save($post);

        return new PostOutput($post);
    }
}