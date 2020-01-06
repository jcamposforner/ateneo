<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\Command;

use App\Shared\Domain\Bus\Query\Query;

final class FindUserQuery implements Query
{
    /**
     * @var int
     */
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function id(): int
    {
        return $this->id;
    }
}