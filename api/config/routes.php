<?php

use Slim\App;
use App\Shared\Infrastructure\Controller\ServiceController;
use App\Admin\Infrastructure\Controller\AdminMigrationsController;
use App\Product\Controller\ProductController;
use App\Order\Controller\OrderController;
use App\Auth\Controller\AuthController;
use App\Customer\Infrastructure\Controller\CustomerController;

return function (App $app) {
    $app->get('/', function ($request, $response, $args) {
        $response = $response->withStatus(302)->withHeader('Location', '/api/ui');
        return $response;
    });



    $app->group('/api', function ($app) {
        $app->get('/health', ServiceController::class . ':health');

        $app->get('/doc', function ($request, $response, $args) {
            $schema = file_get_contents(__DIR__ . '/../public/swagger.json');
            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write($schema);
            return $response;
        });



        $app->get('/ui', function ($request, $response, $args) {
            $response = $response->withHeader('Content-type', 'text/html');
            $response->getBody()->write(file_get_contents(__DIR__ . '/../public/dist/index.html'));
            return $response;
        });

        $app->group('/admin', function ($app) {
            $app->group('/migrations', function ($app) {
                $app->get('/up', AdminMigrationsController::class . ':up');
                $app->get('/down', AdminMigrationsController::class . ':down');
            });
        });


        $app->group('/product', function ($app) {
            $app->get('/products', ProductController::class . ':getProducts');
            $app->get('/products/{id}', ProductController::class . ':getProduct');
        });

        $app->group('/customer', function ($app) {
            $app->get('/account/{id}', CustomerController::class . ':getAccountData');
            $app->put('/account/{id}', CustomerController::class . ':updateAccountData');
            $app->delete('/account/{id}', CustomerController::class . ':deleteAccount');
        });

        $app->group('/auth', function ($app) {
            $app->post('/login', AuthController::class . ':login');
            $app->post('/register', AuthController::class . ':register');
            $app->post('/logout', AuthController::class . ':logout');
            $app->post('/refresh', AuthController::class . ':refresh');
            $app->get('/activate/{activationCode}', AuthController::class . ':activateRegistration');
        });

        $app->group('/order', function ($app) {
            $app->get('/orders', OrderController::class . ':getOrders');
            $app->get('/orders/{id}', OrderController::class . ':getOrder');
            $app->post('/orders', OrderController::class . ':createOrder');
            $app->put('/orders', OrderController::class . ':updateOrder');
            $app->delete('/orders/{id}', OrderController::class . ':deleteOrder');
        });

        $app->get('/{path}', function ($request, $response, $args) {
            $path = explode('.', (string)$request->getAttribute('path'));

            if (count($path) != 2) {
                $response = $response->withStatus(404);
                return $response;
            }

            switch ($path[1]) {
                case 'css':
                    $response = $response->withHeader('Content-type', 'text/css');
                    try {
                        $response->getBody()->write(file_get_contents(__DIR__ . '/../public/dist/' . $path[0] . '.css'));
                        $response = $response->withStatus(200);
                    } catch (\Exception $e) {
                        $response = $response->withStatus(404);
                    }
                    break;
                case 'js':
                    $response = $response->withHeader('Content-type', 'application/javascript');
                    try {
                        $response->getBody()->write(file_get_contents(__DIR__ . '/../public/dist/' . $path[0] . '.js'));
                        $response = $response->withStatus(200);
                    } catch (\Exception $e) {
                        $response = $response->withStatus(404);
                    }
                    break;
                case 'png':
                    $response = $response->withHeader('Content-type', 'image/png');
                    try {
                        $response->getBody()->write(file_get_contents(__DIR__ . '/../public/dist/' . $path[0] . '.png'));
                        $response = $response->withStatus(200);
                    } catch (\Exception $e) {
                        $response = $response->withStatus(404);
                    }
                    break;
                default:
                    $response = $response->withStatus(404);
            }
            return $response;
        });
    });
};
