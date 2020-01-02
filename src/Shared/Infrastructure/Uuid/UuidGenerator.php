<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure;

use Ramsey\Uuid\Uuid;

final class UuidGenerator
{
    public function next(): string
    {
        return Uuid::uuid4()->toString();
    }
}