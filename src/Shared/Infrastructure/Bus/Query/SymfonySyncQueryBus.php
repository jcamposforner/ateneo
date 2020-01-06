<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Bus\Query;

use App\Shared\Domain\Bus\ClassNameResolver;
use App\Shared\Domain\Bus\ClassNameResolverInterface;
use App\Shared\Domain\Bus\Query\Query;
use App\Shared\Domain\Bus\Query\QueryBus;
use App\Shared\Domain\Bus\Query\QueryResponse;
use Symfony\Component\Messenger\Exception\NoHandlerForMessageException;
use Symfony\Component\Messenger\Handler\HandlersLocator;
use Symfony\Component\Messenger\MessageBus;
use Symfony\Component\Messenger\Middleware\HandleMessageMiddleware;
use Symfony\Component\Messenger\Stamp\HandledStamp;

class SymfonySyncQueryBus implements QueryBus
{
    /** @var MessageBus  */
    private $bus;

    public function __construct(iterable $queryHandlers)
    {
        $this->bus = new MessageBus(
            [
                new HandleMessageMiddleware(
                    new HandlersLocator(ClassNameResolver::forCallables($queryHandlers))
                ),
            ]
        );
    }

    public function ask(Query $query): ?QueryResponse
    {
        try {
            /** @var HandledStamp $stamp */
            $stamp = $this->bus->dispatch($query)->last(HandledStamp::class);

            return $stamp->getResult();
        } catch (NoHandlerForMessageException $unused) {
            throw new QueryNotRegistered($query);
        }
    }
}