<?php

namespace app\services\prize_handler_service;

interface TypeHandlerInterface
{
    /**
     * Обработка приза
     */
    public function handler(): bool;
}
