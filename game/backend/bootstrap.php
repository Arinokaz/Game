<?php

use app\controllers\Convert;
use app\controllers\Game;
use app\controllers\Login;
use app\controllers\Refuse;
use app\controllers\TakePrize;
use app\services\prizes_service\PrizesService;
use app\services\random_service\RandomService;
use DI\ContainerBuilder;
use Zend\Diactoros\Response;
use Zend\Diactoros\ServerRequestFactory;
use function DI\create;
use function DI\get;

require __DIR__ . '/vendor/autoload.php';

$orm = require __DIR__ . '/db.php';

$request = ServerRequestFactory::fromGlobals();

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(false);
$containerBuilder->useAnnotations(false);
$containerBuilder->addDefinitions([
    Login::class => create(Login::class)
        ->constructor(get('Request'), get('Response'), get('DB')),

    Game::class => create(Game::class)
        ->constructor(get('Request'), get('Response'), get('DB'), get('PrizesService')),

    TakePrize::class => create(TakePrize::class)
        ->constructor(get('Request'), get('Response'), get('DB')),

    Convert::class => create(Convert::class)
        ->constructor(get('Request'), get('Response'), get('DB')),

    Refuse::class => create(Refuse::class)
        ->constructor(get('Request'), get('Response'), get('DB')),

    'PrizesService' => create(PrizesService::class)
        ->constructor(get('RandomService')),

    'Response' => function () {
        return new Response();
    },

    'Request' => function () use ($request) {
        return $request;
    },

    'DB' => function () use ($orm) {
        return $orm;
    },

    'RandomService' => function () {
        return new RandomService();
    },
]);

$container = $containerBuilder->build();

return $container;
