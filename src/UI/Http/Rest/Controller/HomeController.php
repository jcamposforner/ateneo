<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;

class HomeController
{
    /**
     * @param int $id
     * @return Response
     */
    public function __invoke(int $id)
    {
        return new Response("<h1>PAGINA INICIO</h1>". $id);
    }
}