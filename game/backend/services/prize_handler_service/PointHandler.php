<?php

namespace app\services\prize_handler_service;

use app\models\Prize;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Exception;

class PointHandler implements TypeHandlerInterface
{

    public function __construct(Prize $prize, ORM $orm)
    {
        $this->prize = $prize;
        $this->orm = $orm;
    }

    public function handler(): bool
    {
        $last_points = $this->prize->getUser()->getPoints();
        $this->prize->getUser()->setPoints($last_points + $this->prize->getValue());

        $this->prize->setStatus(Prize::STATUS_TAKE);
        $this->prize->setProcessed(Prize::PROCESSED_SUCCESS);

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
