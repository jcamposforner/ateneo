<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\Command;

use App\Shared\Domain\Bus\Query\QueryHandler;

final class FindUserQueryHandler implements QueryHandler
{
    public function __invoke(FindUserQuery $findUserQuery)
    {
        dd($findUserQuery);
    }
}