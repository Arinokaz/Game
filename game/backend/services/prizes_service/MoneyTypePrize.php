<?php

namespace app\services\prizes_service;

use app\services\random_service\RandomServiceInterface;

class MoneyTypePrize implements TypePrizeInterface
{
    const MIN = 1;
    const MAX = 1000;

    private RandomServiceInterface $randomService;

    public function __construct(RandomServiceInterface $randomService)
    {
        $this->randomService = $randomService;
    }

    public function getPrize()
    {
        return $this->randomService->randomNumber($this->getMin(), $this->getMax());
    }

    private function getMin(): int
    {
        return self::MIN;
    }

    private function getMax(): int
    {
        return self::MAX;
    }
}
