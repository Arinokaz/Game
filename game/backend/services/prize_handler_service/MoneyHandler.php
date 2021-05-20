<?php

namespace app\services\prize_handler_service;

use app\models\Prize;
use Cycle\ORM\ORM;
use Cycle\ORM\Transaction;
use Exception;

class MoneyHandler implements TypeHandlerInterface
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
        } catch (Exception $e) {
            return false;
        }

        return $this->sendMoneyToCard($this->prize);
    }

    /**
     * Метод который отсылает деньги клиента на карту. Возможна обработка в очереди,
     * поэтому статус processed должен выставляться после после того как прийдет подтверждение
     * что оплата прошла успешно.
     *
     * @param Prize $prize
     *
     * @return void
     */
    private function sendMoneyToCard($prize)
    {
        return true;
    }
}
