<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

class SearchPostInput
{
    public string $q;
    public array $tags;
    public int $page;
    public int $perPage;

    public function __construct(
        string $q,
        array $tags,
        int   $page,
        int   $perPage,
    )
    {
        $this->q = $q;
        $this->tags = $tags;
        $this->page = $page;
        $this->perPage = $perPage;
    }
}