<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;
use Swagger\Swagger;

require_once __DIR__ . '/../vendor/autoload.php';



$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $builder->build();

// Register dependencies

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

(require __DIR__ . '/../config/routes.php')($app);

(require __DIR__ . '/../config/middleware.php')($app);

(require __DIR__ . '/../config/migration.php')($container);

$app->run();
