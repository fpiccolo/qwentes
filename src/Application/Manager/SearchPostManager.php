<?php
declare(strict_types=1);

namespace App\Application\Manager;

use App\Application\DTO\Input\SearchPostInput;
use App\Application\DTO\Output\PostOutput;
use App\Application\DTO\Output\SearchPostOutput;
use App\Domain\Entity\Post;
use App\Infrastructure\Repository\PostRepository;

class SearchPostManager
{
    private PostRepository $postRepository;

    public function __construct(
        PostRepository $userRepository,
    )
    {
        $this->postRepository = $userRepository;
    }

    public function search(SearchPostInput $searchPostInput): SearchPostOutput
    {
        list($posts, $totalItems, $pageCount) = $this->postRepository->search(
            $searchPostInput->page,
            $searchPostInput->perPage,
            $searchPostInput->q,
            $searchPostInput->tags,
        );

        $postOutput = [];
        /** @var Post $post */
        foreach ($posts as $post){
            $postOutput[] = new PostOutput($post);
        }

        return new SearchPostOutput(
            $totalItems,
            $postOutput
        );
    }
}