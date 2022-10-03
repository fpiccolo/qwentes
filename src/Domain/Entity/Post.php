<?php
declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Enum\PostStatus;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity, Table(name: 'post')]
class Post
{
    #[Id, Column(type: 'uuid')]
    private UuidInterface $id;

    #[Column(type: 'string', unique: true)]
    private string $title;

    #[Column(type: 'string')]
    private string $body;

    #[Column(type: 'string')]
    private string $status;

    #[OneToMany(mappedBy: 'post', targetEntity: PostTag::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $tags;

    public function __construct(
        UuidInterface $id,
        string $title,
        string $body,
        PostStatus $status,
    )
    {
        $this->id = $id;
        $this->title = $title;
        $this->body = $body;
        $this->status = $status->value;
        $this->tags = new ArrayCollection();
    }

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getStatus(): PostStatus
    {
        return PostStatus::from($this->status);
    }

    /**
     * @return PostTag[]
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(PostTag $tag): self
    {
        if (!$this->tags->contains($tag)) {
            $this->tags[] = $tag;
            $tag->setPost($this);
        }

        return $this;
    }

    public function removeTag(PostTag $tag): self
    {
        $this->tags->removeElement($tag);

        return $this;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $body
     */
    public function setBody(string $body): void
    {
        $this->body = $body;
    }

    /**
     * @param PostStatus $status
     */
    public function setStatus(PostStatus $status): void
    {
        $this->status = $status->value;
    }

    /**
     * @param Collection $tags
     */
    public function setTags(Collection $tags): void
    {
        $this->clearTags();
        foreach ($tags as $tag){
            $this->addTag($tag);
        }
    }

    private function clearTags(): void
    {
        foreach ($this->tags as $tag){
            $this->removeTag($tag);
        }
    }






}