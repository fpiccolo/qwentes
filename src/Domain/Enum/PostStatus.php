<?php
declare(strict_types=1);

namespace App\Domain\Enum;

enum PostStatus: string
{
    case Online = 'online';
    case Offline = 'offline';
}