<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\RabbitMQ;

use AMQPQueue;
use Psr\Log\LoggerInterface;

final class RabbitMQDomainEventConsumer
{
    /**
     * @var RabbitMQConnection
     */
    private $connection;
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(RabbitMQConnection $connection, LoggerInterface $logger)
    {
        $this->connection = $connection;
        $this->logger = $logger;
    }

    public function __invoke(string $name)
    {
        $queue = $this->queue($name);

        $consumed = $queue->consume(new RabbitMQConsumer($this->logger));
    }

    private function queue(string $queueName): ?AMQPQueue
    {
        return $this->connection->queue($queueName);
    }
}