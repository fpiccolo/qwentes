<?php
declare(strict_types=1);

namespace App\Application\DTO\Input;

class SearchUserInput
{
    public array $sort;
    public array $countryCode;
    public array $email;
    public int $page;
    public int $perPage;

    public function __construct(
        array $sort,
        array $countryCode,
        array $email,
        int   $page,
        int   $perPage,
    )
    {
        $this->sort = $sort;
        $this->countryCode = $countryCode;
        $this->email = $email;
        $this->page = $page;
        $this->perPage = $perPage;
    }
}