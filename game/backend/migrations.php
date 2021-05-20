#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Cycle\ORM;
use app\models\User;
use Cycle\ORM\Transaction;

$dbal = require './connection.php';
$schemas = require './schemas.php';

$orm = new ORM\ORM(new ORM\Factory($dbal), $schemas);

$users = $dbal->database('default')->table('users')->getSchema();

if (!$users->exists()) {

    $users->column('id')->primary();
    $users->column('login')->string(64);
    $users->column('password')->string(64);
    $users->column('points')->decimal(10,2);
    $users->column('address')->text();
    $users->save();

    $user = new User();
    $user->setLogin('Tester');
    $user->setPassword('0000');
    $user->setPoints(0);
    $user->setAddress('Ukraine, Kherson');

    $tr = new Transaction($orm);
    $tr->persist($user);
    $tr->run();

    $user = new User();
    $user->setLogin('Other');
    $user->setPassword('0000');
    $user->setPoints(0);
    $user->setAddress('Ukraine, Lviv');

    $tr = new Transaction($orm);
    $tr->persist($user);
    $tr->run();
}

$prizes = $dbal->database('default')->table('prizes')->getSchema();

if (!$prizes->exists()) {
    $prizes->column('id')->primary();
    $prizes->column('user_id')->integer();
    $prizes->index(['user_id']);
    $foreignKey = $prizes->foreignKey(['user_id'])->references('users', ['id']);
    $foreignKey->onDelete('CASCADE');
    $prizes->column('type')->tinyInteger();
    $prizes->column('status')->tinyInteger()->defaultValue(0);
    $prizes->column('processed')->boolean();
    $prizes->column('value')->string();
    $prizes->save();
}
