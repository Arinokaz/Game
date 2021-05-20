<?php

namespace app\services\convert_service;

class ConvertService
{

    const DEFAULT_RATE = 1;

    private float $rate;
    private int $money;

    public function __construct(int $money)
    {
        $this->money = $money;
    }

    public function getPoints(): float
    {
        return $this->money * $this->getRate();
    }

    private function getRate(): float
    {
        return $this->rate ?? self::DEFAULT_RATE;
    }

    public function setRate(float $rate)
    {
        $this->rate = $rate;
    }
}
