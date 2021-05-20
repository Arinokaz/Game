<?php

namespace app\services\prizes_service;

interface PrizesServiceInterface
{
    public function getRandomPrizeType();

    public function getPrizesType();

    public function getPrize($type_prize);
}
