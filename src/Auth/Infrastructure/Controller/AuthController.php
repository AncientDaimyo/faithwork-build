<?php

namespace App\Auth\Infrastructure\Controller;

use App\Auth\Application\Boundary\AuthServiceBoundary;
use App\Shared\Infrastructure\Controller\Controller;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use OpenApi\Attributes as OA;

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

    #[OA\Post(path: '/api/auth/login', tags: ['auth'])]
    #[OA\RequestBody(
        content: [
            new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'password', type: 'string'),
                ]
            ),
        ]
    )]
    #[OA\Response(response: 200, description: 'Returns a tokens')]
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

    #[OA\Post(path: '/api/auth/register', tags: ['auth'])]
    #[OA\RequestBody(
        content: [
            new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'email', type: 'string'),
                    new OA\Property(property: 'password', type: 'string'),
                ]
            ),
        ]
    )]
    #[OA\Response(response: 200, description: 'Creates a new user')]
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

    #[OA\Post(path: '/api/auth/refresh', tags: ['auth'])]
    #[OA\RequestBody(
        content: [
            new OA\JsonContent(
                properties: [
                    new OA\Property(property: 'Refresh-Token', type: 'string'),
                ]
            ),
        ]
    )]
    #[OA\Response(response: 200, description: 'Returns a tokens')]
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

    #[OA\Post(path: '/api/auth/logout', tags: ['auth'])]
    #[OA\Response(response: 200, description: 'Deletes tokens')]
    public function logout(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        if (!$this->authService->logout($data)) {
            return $response->withStatus(400);
        }
        return $response->withStatus(200);
    }
}
