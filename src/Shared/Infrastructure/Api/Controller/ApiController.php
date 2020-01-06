<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Api\Controller;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\QueryResponse;
use App\Shared\Infrastructure\Bus\Query\SymfonySyncQueryBus;
use Symfony\Component\Messenger\MessageBusInterface;

abstract class ApiController
{
    /**
     * @var QueryBus
     */
    private $queryBus;
    /**
     * @var MessageBusInterface
     */
    private $commandBus;

    public function __construct(QueryBus $queryBus, MessageBusInterface $commandBus)
    {
        $this->queryBus   = $queryBus;
        $this->commandBus = $commandBus;
    }

    protected function dispatch(Command $command): void
    {
        $this->commandBus->dispatch($command);
    }

    protected function ask(Query $query): ?QueryResponse
    {
        return $this->queryBus->ask($query);
    }
}