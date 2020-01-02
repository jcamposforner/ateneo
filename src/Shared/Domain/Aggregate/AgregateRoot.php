<?php

declare(strict_types=1);

namespace App\Shared\Domain\Aggregate;

use App\Shared\Domain\Bus\Event\DomainEvent;

trait AgregateRoot
{
    /** @var DomainEvent[] */
    private $domainEvents = [];

    final public function pullDomainEventes(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final protected function record(DomainEvent $domainEvent):void
    {
        $this->domainEvents[] = $domainEvent;
    }
}