<?php

use PHPUnit\Framework\TestCase;
use app\services\convert_service\ConvertService;

class ConvertServiceTest extends TestCase
{

    public function testGetPointWithDefaultRate()
    {
        $convertService = new ConvertService(100);
        $this->assertEquals(100, $convertService->getPoints());
    }

    public function testGetPointWithCustomRate()
    {
        $convertService = new ConvertService(105);
        $convertService->setRate(1.5);
        $this->assertEquals(157.5, $convertService->getPoints());
    }

    public function testGetPointWithCustomRateAndNotSetMoney()
    {
        $this->expectException(ArgumentCountError::class);
        $convertService = new ConvertService();
        $convertService->setRate(1.5);
        $this->assertEquals(150, $convertService->getPoints());
    }
}
