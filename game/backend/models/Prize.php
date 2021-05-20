<?php

namespace app\models;

class Prize
{
    /**
     * Статус того что выгран приз
     */
    const STATUS_GET  = 0;

    /**
     * Статус того что дали добро на получение приза
     */
    const STATUS_TAKE = 1;

    /**
     * Статус того что приз ждет обработки
     */
    const PROCESSED_WAIT     = 0;

    /**
     * Статус того что приз обработан
     */
    const PROCESSED_SUCCESS  = 1;

    const TYPE_MONEY  = 1;
    const TYPE_POINT  = 2;
    const TYPE_THING  = 3;

    protected $id;
    protected $user_id;
    protected $type;
    protected $status;
    protected $processed;
    protected $value;
    protected $user;

    public function getId()
    {
        return $this->id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getProcessed()
    {
        return $this->processed;
    }

    public function setProcessed($processed)
    {
        $this->processed = $processed;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }
}
