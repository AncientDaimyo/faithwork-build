<?php

namespace App\Auth\Infrastructure\Controller;

use App\Auth\Application\Boundary\AuthServiceBoundary;
use App\Shared\Infrastructure\Controller\Controller;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;

class AuthController extends Controller
{
    protected AuthServiceBoundary $authService;

    public function __construct(
        ContainerInterface $container,
        AuthServiceBoundary $authService
    ) {
        parent::__construct($container);
        $this->authService = $authService;
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try {
            $token = $this->authService->login($data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($token));

        return $response->withStatus(200);
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try {
            $this->authService->register($data);
        } catch (\InvalidArgumentException $exception) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }

    public function refresh(Request $request, Response $response): Response
    {
        $refreshToken = $request->getHeader('Refresh-Token')[0];    

        if (empty($refreshToken)) {
            return $response->withStatus(400);
        }

        try {
            $token = $this->authService->refresh($refreshToken);
        } catch (\InvalidArgumentException $exception) {
            $response->getBody()->write(json_encode($exception->getMessage()));
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($token));

        return $response->withStatus(200);
    }

    public function logout(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        if (!$this->authService->logout($data)) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }
}
