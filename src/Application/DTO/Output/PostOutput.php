<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

use App\Domain\Entity\Post;
use App\Domain\Enum\PostStatus;

class PostOutput
{
    public string $id;
    public string $title;
    public string $body;
    public PostStatus $status;
    /** @var string[] */
    public array $tags = [];

    public function __construct(Post $post)
    {
        $this->id = $post->getId()->toString();
        $this->title = $post->getTitle();
        $this->body = $post->getBody();
        $this->status = $post->getStatus();

        foreach ($post->getTags() as $tag){
            $this->tags[] = $tag->getTag();
        }
    }
}