<?php

declare(strict_types=1);

namespace App\Command;

use App\Shared\Infrastructure\RabbitMQ\RabbitMQDomainEventConsumer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class ConsumeDomainEvents extends Command
{
    /**
     * @var RabbitMQDomainEventConsumer
     */
    private $consumer;

    public function __construct(RabbitMQDomainEventConsumer $consumer)
    {
        parent::__construct();
        $this->consumer = $consumer;
    }

    protected function configure(): void
    {
        $this
            ->setName('app:consume:rabbit')
            ->setDescription('Consume domain events')
            ->addArgument('subscriber', InputArgument::REQUIRED, 'Subscriber to process');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $subscriberName = $input->getArgument('subscriber');

        $this->consume($subscriberName);
    }

    private function consume(string $subscriberName): void
    {
        $this->consumer->__invoke($subscriberName);
    }
}