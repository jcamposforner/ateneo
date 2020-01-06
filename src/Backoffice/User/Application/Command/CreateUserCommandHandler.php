<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\Command;

use App\Backoffice\User\Domain\User;
use App\Shared\Domain\Bus\Command\CommandHandler;
use Doctrine\ORM\EntityManagerInterface;

final class CreateUserCommandHandler implements CommandHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function __invoke(CreateUserCommand $command)
    {
        $user = User::createDefaultUser($command->getUserId(), $command->getUserName(), $command->getPassword(), $command->getEmail());
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}