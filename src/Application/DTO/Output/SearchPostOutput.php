<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class SearchPostOutput
{
    public int $totalItems;
    /**
     * @var PostOutput[]
     */
    public array $items;

    /**
     * @param PostOutput[] $items
     */
    public function __construct(int $totalItems, array $items)
    {
        $this->totalItems = $totalItems;
        $this->items = $items;
    }
}