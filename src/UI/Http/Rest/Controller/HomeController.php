<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use App\Backoffice\User\Application\Command\CreateUserCommand;
use App\Backoffice\User\Application\Command\FindUserQuery;
use App\Shared\Infrastructure\Api\Controller\ApiController;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends ApiController
{
    /**
     * @return Response
     */
    public function __invoke()
    {
        $user = $this->ask(new FindUserQuery(1));
        return new Response("<h1>PAGINA INICIO</h1>");
    }
}