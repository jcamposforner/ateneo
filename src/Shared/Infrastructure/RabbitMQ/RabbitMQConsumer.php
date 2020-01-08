<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\RabbitMQ;

use Psr\Log\LoggerInterface;
use AMQPEnvelope;
use AMQPQueue;

final class RabbitMQConsumer
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function __invoke(AMQPEnvelope $envelope, AMQPQueue $queue)
    {
        $queueName = $queue->getName();

        dd($envelope);
    }
}