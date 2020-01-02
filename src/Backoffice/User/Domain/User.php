<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain;

use App\Shared\Domain\Aggregate\AgregateRoot;
use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\UuidInterface;

/**
 * @ORM\Entity()
 */
final class User extends BaseUser
{
    use AgregateRoot;

    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $uuid;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $uuid
     * @return $this
     */
    public function setUuid(string $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    /**
     * @param string $uuid
     * @param string $userName
     * @param string $password
     * @param string $email
     *
     * @return static
     */
    public static function createDefaultUser(string $uuid, string $userName, string $password, string $email): self
    {
        $user = new static();

        $user->setUuid($uuid)
            ->setUsername($userName)
            ->setPlainPassword($password)
            ->setEmail($email)
            ->setEnabled(true)
            ->setRoles([static::ROLE_DEFAULT])
            ->setSuperAdmin(false);

        return $user;
    }
}