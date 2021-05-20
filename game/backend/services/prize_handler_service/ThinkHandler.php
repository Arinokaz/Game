<?php

namespace app\services\prize_handler_service;

use app\models\Prize;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Exception;

class ThinkHandler implements TypeHandlerInterface
{
    public function __construct(Prize $prize, ORM $orm)
    {
        $this->prize = $prize;
        $this->orm = $orm;
    }

    public function handler(): bool
    {
        $this->prize->setStatus(Prize::STATUS_TAKE);

        $t = new Transaction($this->orm);
        $t->persist($this->prize);

        try {
            $t->run();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
