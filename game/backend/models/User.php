<?php

namespace app\models;

use Doctrine\Common\Collections\ArrayCollection;

class User
{
    protected $id;
    protected $login;
    protected $password;
    protected $points;
    protected $address;
    protected $prizes;

    public function __construct()
    {
        $this->prizes = new ArrayCollection();
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getPrizes()
    {
        return $this->prizes;
    }
}
