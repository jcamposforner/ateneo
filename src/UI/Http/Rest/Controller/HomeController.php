<?php

declare(strict_types=1);

namespace App\UI\Http\Rest\Controller;

use Symfony\Component\HttpFoundation\Response;

class HomeController
{
    /**
     * @return Response
     */
    public function __invoke(int $id)
    {
        return new Response("a". $id);
    }
}