<?php
declare(strict_types=1);

namespace App\Application\DTO\Output;

class SearchUserOutput
{
    public int $totalItems;
    /**
     * @var UserOutput[]
     */
    public array $items;

    /**
     * @param UserOutput[] $items
     */
    public function __construct(int $totalItems, array $items)
    {
        $this->totalItems = $totalItems;
        $this->items = $items;
    }
}