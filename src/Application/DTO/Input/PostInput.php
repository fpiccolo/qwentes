<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

use App\Domain\Enum\PostStatus;

class PostInput
{
    public string $title;
    public string $body;
    public PostStatus $status;
    /** @var string[] */
    public array $tags;

    /**
     * @param string[] $tags
     */
    public function __construct(
        string $title,
        string $body,
        PostStatus $status,
        array $tags
    )
    {
        $this->title = $title;
        $this->body = $body;
        $this->status = $status;
        $this->tags = $tags;
    }
}