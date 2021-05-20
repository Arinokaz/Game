<?php

use app\controllers\Convert;
use app\controllers\Game;
use app\controllers\Login;
use app\controllers\Refuse;
use app\controllers\TakePrize;
use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

return simpleDispatcher(function (RouteCollector $r) {
    $r->post('/login', Login::class);
    $r->post('/game', Game::class);
    $r->post('/take-prize', TakePrize::class);
    $r->post('/convert', Convert::class);
    $r->post('/refuse', Refuse::class);
});