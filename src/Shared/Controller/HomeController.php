<?php

namespace App\Shared\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Container\ContainerInterface;

class HomeController extends BaseController
{
    public function index(Request $request, Response $response): Response
    {
        return $response->withStatus(200);
    }
}

