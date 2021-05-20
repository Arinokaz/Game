<?php

namespace app\models;

use Cycle\ORM\Select;

class PrizeRepository extends Select\Repository
{
    public function findMoneyNotProcessed($limit): Select
    {
        return $this->select()->where('status', Prize::STATUS_TAKE)->andWhere('type', Prize::TYPE_MONEY )->andWhere('processed', Prize::PROCESSED_WAIT)->limit($limit);
    }
}
