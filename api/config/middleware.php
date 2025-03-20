<?php

use Psr\Http\Server\RequestHandlerInterface;
use Slim\App;
use App\Shared\Domain\Storage\AppEnvStorage;
use Slim\Psr7\Request;
use Slim\Psr7\Response;

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

    $app->add(function (Request $request, RequestHandlerInterface $handler) use ($app): Response {
        if ($request->getMethod() === 'OPTIONS') {
            $response = $app->getResponseFactory()->createResponse();
        } else {
            $response = $handler->handle($request);
        }
    
        $response = $response
            ->withHeader('Access-Control-Allow-Credentials', 'true')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withHeader('Access-Control-Allow-Headers', '*')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS')
            ->withHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->withHeader('Pragma', 'no-cache');
    
        if (ob_get_contents()) {
            ob_clean();
        }
    
        return $response;
    });
};
