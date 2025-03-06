<?php

use Slim\Factory\AppFactory;
use DI\ContainerBuilder;

require_once __DIR__ . '/../vendor/autoload.php';

(require_once __DIR__ . '/../config/dotenv.php')();


$builder = new ContainerBuilder();
$builder->addDefinitions(__DIR__ . '/../config/container.php');
$container = $builder->build();

AppFactory::setContainer($container);
$app = AppFactory::create();

(require_once __DIR__ . '/../config/routes.php')($app);

(require_once __DIR__ . '/../config/middleware.php')($app);

(require_once __DIR__ . '/../config/migration.php')($container);

$app->run();
