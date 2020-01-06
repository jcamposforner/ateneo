<?php

declare(strict_types=1);

namespace App\Backoffice\User\Application\Command;

use App\Shared\Domain\Bus\Command\Command;
use App\Shared\Domain\Bus\Query\Query;

class CreateUserCommand implements Query
{
    /**
     * @var string
     */
    private $commandId;
    /**
     * @var string
     */
    private $userId;
    /**
     * @var string
     */
    private $userName;
    /**
     * @var string
     */
    private $email;
    /**
     * @var string
     */
    private $password;

    public function __construct(string $commandId, string $userId, string $userName, string $email, string $password)
    {
        $this->commandId = $commandId;
        $this->userId    = $userId;
        $this->userName  = $userName;
        $this->email     = $email;
        $this->password  = $password;
    }

    /**
     * @return string
     */
    public function getCommandId(): string
    {
        return $this->commandId;
    }

    /**
     * @return string
     */
    public function getUserId(): string
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}