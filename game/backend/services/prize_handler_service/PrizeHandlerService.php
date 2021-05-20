<?php

namespace app\services\prize_handler_service;

use app\models\Prize;
use Cycle\ORM\ORM;

class PrizeHandlerService
{
    private Prize $prize;

    private ORM $orm;

    private array $prizes = [
        Prize::TYPE_MONEY => MoneyHandler::class,
        Prize::TYPE_POINT => PointHandler::class,
        Prize::TYPE_THING => ThinkHandler::class,
    ];

    public function __construct(Prize $prize, ORM $orm)
    {
        $this->prize = $prize;
        $this->orm = $orm;
    }

    public function handler()
    {
        return (new $this->prizes[$this->prize->getType()]($this->prize, $this->orm))->handler();
    }
}
