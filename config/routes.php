<?php

use Slim\App;

return function (App $app) {
    $app->get('/', function ($request, $response, $args) {
        $response = $response->withStatus(302)->withHeader('Location', '/api/doc');
        return $response;
    });



    $app->group('/api', function ($app) {
        $app->get('/health', function ($request, $response, $args) {
            $response = $response->withStatus(200);
            return $response;
        });

        $app->get('/doc', function ($request, $response, $args) {
            $openapi = \OpenApi\Generator::scan([__DIR__ . '/../src']);

            $response = $response->withHeader('Content-type', 'application/json');
            $response->getBody()->write($openapi->toJson());
            return $response;
        });
        $app->group('/admin', function ($app) {
            $app->group('/migrations', function ($app) {
                $app->get('/up', \App\Admin\Infrastructure\Controller\AdminMigrationsController::class . ':up');
                $app->get('/down', \App\Admin\Infrastructure\Controller\AdminMigrationsController::class . ':down');
            });
        });
      

        $app->group('/product', function ($app) {
            $app->get('/products', \App\Product\Infrastructure\Controller\ProductController::class . ':getProducts');
            $app->get('/products/{id}', \App\Product\Infrastructure\Controller\ProductController::class . ':getProduct');
        });

        $app->group('/customer', function ($app) {
            $app->get('/account/{id}', \App\Customer\Infrastructure\Controller\CustomerController::class . ':getAccountData');
            $app->put('/account/{id}', \App\Customer\Infrastructure\Controller\CustomerController::class . ':updateAccountData');
            $app->delete('/account/{id}', \App\Customer\Infrastructure\Controller\CustomerController::class . ':deleteAccount');
        });

        $app->group('/auth', function ($app) {
            $app->post('/login', \App\Auth\Infrastructure\Controller\AuthController::class . ':login');
            $app->post('/register', \App\Auth\Infrastructure\Controller\AuthController::class . ':register');
            $app->post('/logout', \App\Auth\Infrastructure\Controller\AuthController::class . ':logout');
            $app->post('/refresh', \App\Auth\Infrastructure\Controller\AuthController::class . ':refresh');
            $app->post('/token', \App\Auth\Infrastructure\Controller\AuthController::class . ':getToken');
        });

        $app->group('/order', function ($app) {
            $app->get('/orders', \App\Order\Infrastructure\Controller\OrderController::class . ':getOrders');
            $app->get('/orders/{id}', \App\Order\Infrastructure\Controller\OrderController::class . ':getOrder');
            $app->post('/orders', \App\Order\Infrastructure\Controller\OrderController::class . ':createOrder');
            $app->put('/orders/{id}', \App\Order\Infrastructure\Controller\OrderController::class . ':updateOrder');
            $app->delete('/orders/{id}', \App\Order\Infrastructure\Controller\OrderController::class . ':deleteOrder');
        });
    });
};
