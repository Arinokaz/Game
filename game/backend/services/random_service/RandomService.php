<?php

namespace app\services\random_service;

class RandomService implements RandomServiceInterface
{
    public function randomNumber(int $min, int $max): int
    {
        return random_int($min, $max);
    }

    public function randomArrayValue(array $array)
    {
        shuffle($array);
        $min = 0;
        $max = count($array) - 1;
        return $array[random_int($min, $max)];
    }
}
