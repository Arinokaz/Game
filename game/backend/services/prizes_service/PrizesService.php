<?php

namespace app\services\prizes_service;

use app\models\Prize;
use app\services\random_service\RandomService;
use app\services\random_service\RandomServiceInterface;

class PrizesService implements PrizesServiceInterface
{

    private array $prizes = [
        Prize::TYPE_MONEY => MoneyTypePrize::class,
        Prize::TYPE_POINT => PointTypePrize::class,
        Prize::TYPE_THING => ThinkTypePrize::class,
    ];

    private RandomServiceInterface $randomService;

    public function __construct(RandomServiceInterface $randomService)
    {
        $this->randomService = $randomService;
    }

    public function getRandomPrizeType()
    {
        $listPrizes = array_keys($this->getPrizesType());
        shuffle($listPrizes);
        return $this->randomService->randomArrayValue($listPrizes);
    }

    public function getPrizesType()
    {
        return $this->prizes;
    }

    public function getPrize($type_prize)
    {
        return (new $this->prizes[$type_prize](new RandomService()))->getPrize();
    }
}
