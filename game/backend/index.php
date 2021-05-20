<?php
declare(strict_types=1);

use Middlewares\FastRoute;
use Middlewares\RequestHandler;
use Narrowspark\HttpEmitter\SapiEmitter;
use Relay\Relay;
use Zend\Diactoros\ServerRequestFactory;


require __DIR__ . '/cors.php';

$container = require __DIR__ . '/bootstrap.php';

$routes = require __DIR__ . '/routes.php';

$middlewareQueue[] = new FastRoute($routes);
$middlewareQueue[] = new RequestHandler($container);


$requestHandler = new Relay($middlewareQueue);
$response = $requestHandler->handle(ServerRequestFactory::fromGlobals());

$emitter = new SapiEmitter();

return $emitter->emit($response);
