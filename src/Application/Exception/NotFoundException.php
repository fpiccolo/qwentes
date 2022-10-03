<?php
declare(strict_types=1);

namespace App\Application\Exception;

class NotFoundException extends \Exception
{

    protected $code = 404;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->code, null);
    }
}