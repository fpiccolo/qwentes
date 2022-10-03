<?php
declare(strict_types=1);

namespace App\Application\Exception;


use Ramsey\Uuid\UuidInterface;

class PostNotFondException extends NotFoundException
{

    public function __construct(UuidInterface $id)
    {
        parent::__construct("Post with id [{$id}] not found");
    }
}