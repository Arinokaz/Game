<?php

use PHPUnit\Framework\TestCase;
use app\services\random_service\RandomService;

class RandomServiceTest extends TestCase
{

    protected $randomService;
    protected $list;
    protected $min;
    protected $max;

    protected function setUp(): void
    {
        $this->min = 0;
        $this->max = 5;
        $this->list = ['q', 'w', 'e', 'r', 't', 'y'];
        $this->randomService = new RandomService();
    }

    public function testRandomNumber()
    {
        for ($i = 0; $i < 100; $i++) {
            $number = $this->randomService->randomNumber($this->min, $this->max);
            $this->assertContains($number, range($this->min, $this->max));
        }
    }

    public function testRandomArrayValue()
    {
        for ($i = 0; $i < 100; $i++) {
            $value = $this->randomService->randomArrayValue($this->list);
            $this->assertContains($value, $this->list);
        }
    }
}
