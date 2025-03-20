<?php

use Slim\App;
use App\Shared\Domain\Storage\AppEnvStorage;

return function (App $app) {
    $app->addBodyParsingMiddleware();

    $app->addRoutingMiddleware();

    switch ($_ENV['APP_ENV']) {
        case AppEnvStorage::DEV:
            $app->addErrorMiddleware(true, true, true);
            break;
        case AppEnvStorage::TEST:
            $app->addErrorMiddleware(false, false, false);
            break;
        default:
            $app->addErrorMiddleware(false, true, true);
            break;
    }
};
