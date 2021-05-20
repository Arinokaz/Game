<?php

use PHPUnit\Framework\TestCase;
use app\services\prizes_service\PrizesService;
use app\services\random_service\RandomService;
use app\services\prizes_service\TypePrizeInterface;
use app\models\Prize;

class PrizesServiceTest extends TestCase
{

    public function testGetRandomPrizeType()
    {
        $prizesService = new PrizesService(new RandomService());
        $type = $prizesService->getRandomPrizeType();
        $this->assertArrayHasKey($type, $prizesService->getPrizesType());
    }

    public function testGetPrizeMoneyType()
    {
        $prizesService = new PrizesService(new RandomService());
        $prize = $prizesService->getPrize(Prize::TYPE_MONEY);
        $this->assertNotNull($prize);
    }

    public function testGetPrizePointType()
    {
        $prizesService = new PrizesService(new RandomService());
        $prize = $prizesService->getPrize(Prize::TYPE_POINT);
        $this->assertNotNull($prize);
    }

    public function testGetPrizeThingType()
    {
        $prizesService = new PrizesService(new RandomService());
        $prize = $prizesService->getPrize(Prize::TYPE_THING);
        $this->assertNotNull($prize);
    }

}