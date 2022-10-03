<?php
declare(strict_types=1);

namespace App\Application\Exception;

use Slim\Psr7\Response;

class BadRequestException extends \Exception
{

    protected $code = 400;

    public function __construct(string $message = "")
    {
        parent::__construct($message, $this->code, null);
    }
}