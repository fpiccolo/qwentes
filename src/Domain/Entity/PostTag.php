<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity, Table(name: 'post_tag')]
class PostTag
{
    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column(type: 'string')]
    private string $tag;

    #[ManyToOne(targetEntity: Post::class, inversedBy: 'tags')]
    #[JoinColumn(name: "postId", referencedColumnName: 'id', nullable: false)]
    private Post $post;

    public function __construct(
        UuidInterface $id,
        string $tag
    )
    {
        $this->id = $id;
        $this->tag = $tag;
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTag(): string
    {
        return $this->tag;
    }

    public function getPost(): Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     */
    public function setPost(Post $post): void
    {
        $this->post = $post;
    }




}