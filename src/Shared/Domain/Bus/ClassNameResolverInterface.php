<?php

declare(strict_types=1);

namespace App\Shared\Domain\Bus;

interface ClassNameResolverInterface
{
    public function get(iterable $query);
}