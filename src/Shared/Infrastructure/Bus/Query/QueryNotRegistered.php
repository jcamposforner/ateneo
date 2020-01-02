<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;


use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\DomainError;

final class QueryNotRegistered extends DomainError
{
    /**
     * @var Query
     */
    private $query;

    public function __construct(Query $query)
    {
        $this->query = $query;

        parent::__construct();
    }

    public function errorCode(): string
    {
        return 'query_bus_not_registered_error';
    }

    public function errorMessage(): string
    {
        return sprintf('The query <%s> has not been registered', get_class($this->query));
    }
}