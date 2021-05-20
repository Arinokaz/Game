<?php

namespace app\services\prizes_service;

use app\services\random_service\RandomServiceInterface;

class ThinkTypePrize implements TypePrizeInterface
{

    private RandomServiceInterface $randomService;

    public function __construct(RandomServiceInterface $randomService)
    {
        $this->randomService = $randomService;
    }

    public function getPrize()
    {
        return $this->randomService->randomArrayValue($this->getListThinks());
    }

    private function getListThinks(): array
    {
        return [
            'Велосипед',
            'Машина',
            'Квартира',
            'Мобильный телефон',
            'Ноутбук',
        ];
    }
}
