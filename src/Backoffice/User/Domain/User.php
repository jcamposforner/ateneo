<?php

declare(strict_types=1);

namespace App\Backoffice\User\Domain;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 */
final class User extends BaseUser
{
    /**
     * @var integer
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
    }

    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param string $userName
     * @param string $password
     * @param string $email
     *
     * @return static
     */
    public static function createDefaultUser(string $userName, string $password, string $email): self
    {
        $user = new static();

        $user->setUsername($userName)
            ->setPlainPassword($password)
            ->setEmail($email)
            ->setEnabled(true)
            ->setRoles([static::ROLE_DEFAULT])
            ->setSuperAdmin(false);

        return $user;
    }
}