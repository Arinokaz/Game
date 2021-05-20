<?php

namespace app\services\random_service;

interface RandomServiceInterface
{
    public function randomNumber(int $min, int $max): int;
    public function randomArrayValue(array $array);
}
