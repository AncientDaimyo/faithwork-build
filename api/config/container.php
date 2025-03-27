<?php

use App\Auth\Service\AuthService;
use App\Auth\Interface\AuthServiceInterface;
use App\Order\Service\OrderService;
use App\Order\Interface\OrderServiceInterface;
use App\Product\Service\ProductService;
use App\Product\Interface\ProductServiceInterface;
use App\Shared\Utility\Migrations\Adapter\Doctrine\DbalAdapter;
use App\Shared\Utility\Migrations\Api\MigrationExecutor;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;

return [
    'settings' => function () {
        return require __DIR__ . '/settings.php';
    },

    App::class => function (ContainerInterface $container) {
        AppFactory::setContainer($container);

        return AppFactory::create();
    },

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getResponseFactory();
    },

    ErrorMiddleware::class => function (ContainerInterface $container) {
        $app = $container->get(App::class);
        $settings = $container->get('settings')['error'];

        return new ErrorMiddleware(
            $app->getCallableResolver(),
            $app->getResponseFactory(),
            (bool) $settings['display_error_details'],
            (bool) $settings['log_errors'],
            (bool) $settings['log_error_details']
        );
    },

    'connection' => function (ContainerInterface $container) {
        return $container->get(Connection::class);
    },

    'secretKey' => function (ContainerInterface $container) {
        return $container->get('settings')['secretKey'];
    },

    'domain' => function (ContainerInterface $container) {
        return $container->get('settings')['domain'];
    },

    Connection::class => function (ContainerInterface $container) {
        return DriverManager::getConnection([
            'driver' => $container->get('settings')['database']['driver'],
            'host' => $container->get('settings')['database']['host'],
            'dbname' => $container->get('settings')['database']['dbname'],
            'user' => $container->get('settings')['database']['user'],
            'password' => $container->get('settings')['database']['password'],
            'port' => $container->get('settings')['database']['port']
        ]);
    },

    MigrationExecutor::class => function (ContainerInterface $container) {
        return new MigrationExecutor(
            $container->get('adapter'),
            $container->get('migrations_path'),
            $container
        );
    },

    'adapter' => function (ContainerInterface $container) {
        return new DbalAdapter($container->get(Connection::class), 'migrations');
    },

    'migrations_path' => dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'migrations',

    ProductServiceInterface::class => function (ContainerInterface $container) {
        return $container->get(ProductService::class);
    },

    AuthServiceInterface::class => function (ContainerInterface $container) {
        return $container->get(AuthService::class);
    },

    OrderServiceInterface::class => function (ContainerInterface $container) {
        return $container->get(OrderService::class);
    },
];
