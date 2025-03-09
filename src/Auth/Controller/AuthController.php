<?php

namespace App\Auth\Controller;

use App\Shared\Infrastructure\Controller\Controller;
use App\Auth\Interface\AuthServiceInterface;
use Psr\Container\ContainerInterface;
use Slim\Psr7\Response;
use Slim\Psr7\Request;
use OpenApi\Attributes as OA;

class AuthController extends Controller
{
    protected AuthServiceInterface $authService;

    public function __construct(ContainerInterface $container, AuthServiceInterface $authService)
    {
        parent::__construct($container);
        $this->authService = $authService;
    }

    public function login(Request $request, Response $response): Response
    {
        $data = $this->extractLoginData($request);

        if (!empty($data['error'])) {
            $response->getBody()->write(json_encode($data['error']));
            return $response->withStatus(400);
        }

        $token = $this->authService->login($data['email'], $data['password']);

        if (empty($token)) {
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($token));

        return $response->withStatus(200);
    }

    public function register(Request $request, Response $response): Response
    {
        $data = $this->extractRegisterData($request);

        if (!empty($data['error'])) {
            $response->getBody()->write(json_encode($data['error']));
            return $response->withStatus(400);
        }

        $errors = $this->authService->register($data['email'], $data['password']);

        if (!empty($errors)) {
            $response->getBody()->write(json_encode($errors));
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

        $token = $this->authService->refresh($refreshToken);

        if (empty($token)) {
            return $response->withStatus(400);
        }

        $response->getBody()->write(json_encode($token));

        return $response->withStatus(200);
    }

    public function logout(Request $request, Response $response): Response
    {
        $user = $this->authService->auth($request);

        if (empty($user)) {
            return $response->withStatus(401);
        }

        $this->authService->logout($user->id);

        return $response->withStatus(200);
    }

    protected function extractLoginData(Request $request): array
    {
        $data = $request->getParsedBody();
        switch (true) {
            case !isset($data['email']) || empty($data['email']) || !$this->validateEmail($data['email']):
                return ['error' => 'Invalid email'];
            case !isset($data['password']) || empty($data['password']):
                return ['error' => 'Invalid password'];
            default:
                return ['email' => $data['email'], 'password' => $data['password'], 'error' => ''];
        }
    }

    protected function extractRegisterData(Request $request): array
    {
        // TODO : add validation
        $data = $request->getParsedBody();
        switch (true) {
            case !isset($data['email']) || empty($data['email']) || !$this->validateEmail($data['email']):
                return ['error' => 'Invalid email'];
            case !isset($data['password']) || empty($data['password']):
                return ['error' => 'Invalid password'];
            default:
                return ['email' => $data['email'], 'password' => $data['password'], 'error' => ''];
        }
    }

    protected function validateEmail(string $email): bool
    {
        // return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
        return true;
    }
}
