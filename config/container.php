<?php

use App\Shared\Controller\BaseController;
use Doctrine\DBAL\DriverManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Slim\App;
use Slim\Factory\AppFactory;
use Slim\Middleware\ErrorMiddleware;
use App\Shared\Repository\RepositoryInterface;
use App\Shared\Repository\BaseRepository;
use App\Shared\Utility\Migrations\Adapter\Doctrine\DbalAdapter;
use App\Shared\Utility\Migrations\Api\MigrationExecutor;
use App\Shared\Utility\Migrations\Migration\Migration;

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
        return DriverManager::getConnection([
            'driver' => $container->get('settings')['database']['driver'],
            'host' => $container->get('settings')['database']['host'],
            'dbname' => $container->get('settings')['database']['dbname'],
            'user' => $container->get('settings')['database']['user'],
            'password' => $container->get('settings')['database']['password'],
            'port' => $container->get('settings')['database']['port']
        ]);
    },

    'adapter' => function (ContainerInterface $container) {
        return new DbalAdapter($container->get('connection'), 'migrations');
    },

    'migrations_path' => dirname(__DIR__, 1) . DIRECTORY_SEPARATOR . 'migrations',

    BaseController::class => function (ContainerInterface $container) {
        return new BaseController($container, $container->get(RepositoryInterface::class));
    },  

    RepositoryInterface::class => function (ContainerInterface $container) {
        return new BaseRepository($container->get('connection'));
    },

    Migration::class => function (ContainerInterface $container) {
        return new Migration($container);
    },
];
