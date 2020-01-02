<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Backoffice\User\Application\Command\CreateUserCommand;
use App\Backoffice\User\Domain\User;
use App\Shared\Infrastructure\Uuid\UuidGenerator;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use FOS\UserBundle\Model\UserManager;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Constraints as Assert;

final class RegisterController
{
    public function __invoke(Request $request, UserManagerInterface $userManager, MessageBusInterface $messageBus, UuidGenerator $uuidGenerator)
    {
        $data = json_decode($request->getContent(), true);

        $violations = $this->validateRequest($data);

        if ($violations->count() > 0) {
            return new JsonResponse(["error" => (string) $violations], 500);
        }

        $userName = $data['username'];
        $password = $data['password'];
        $email    = $data['email'];
        $uuid     = $uuidGenerator->next();

        $messageBus->dispatch(new CreateUserCommand("1", $uuid, $userName, $email, $password));

        return new JsonResponse([], 201);
    }

    /**
     * @param $data
     * @return ConstraintViolationListInterface
     */
    protected function validateRequest($data): ConstraintViolationListInterface
    {
        $validator = Validation::createValidator();

        $constraint = new Assert\Collection([
            'username' => new Assert\Length(['min' => 1]),
            'password' => new Assert\Length(['min' => 1]),
            'email' => new Assert\Email(),
        ]);

        $violations = $validator->validate($data, $constraint);
        return $violations;
    }
}