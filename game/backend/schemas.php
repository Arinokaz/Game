<?php

use app\models\Prize;
use app\models\PrizeRepository;
use app\models\User;
use app\models\UserRepository;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\Relation;
use Cycle\ORM\Schema;

return new Schema([
    'user'    => [
        Schema::ENTITY      => User::class,
        Schema::REPOSITORY  => UserRepository::class,
        Schema::MAPPER      => Mapper::class,
        Schema::DATABASE    => 'default',
        Schema::TABLE       => 'users',
        Schema::PRIMARY_KEY => 'id',
        Schema::COLUMNS     => [
            'id'        => 'id',
            'login'     => 'login',
            'password'  => 'password',
            'points'    => 'points',
            'address'   => 'address'
        ],
        Schema::TYPECAST  => [],
        Schema::TYPECAST  => [],
        Schema::SCHEMA    => [],
        Schema::RELATIONS => [
            'prizes' => [
                Relation::TYPE   => Relation::HAS_MANY,
                Relation::TARGET => 'prize',
                Relation::SCHEMA => [
                    Relation::CASCADE   => true,
                    Relation::INNER_KEY => 'id',
                    Relation::OUTER_KEY => 'user_id',
                ],
            ]
        ],
    ],
    'prize' => [
        Schema::ENTITY      => Prize::class,
        Schema::REPOSITORY  => PrizeRepository::class,
        Schema::MAPPER      => Mapper::class,
        Schema::DATABASE    => 'default',
        Schema::TABLE       => 'prizes',
        Schema::PRIMARY_KEY => 'id',
        Schema::COLUMNS     => [
            'id'        => 'id',
            'user_id'   => 'user_id',
            'type'      => 'type',
            'status'    => 'status',
            'processed' => 'processed',
            'value'     => 'value',
        ],
        Schema::TYPECAST    => [],
        Schema::RELATIONS   => [
            'user' => [
                Relation::TYPE   => Relation::BELONGS_TO,
                Relation::TARGET => 'user',
                Relation::SCHEMA => [
                    Relation::CASCADE   => true,
                    Relation::INNER_KEY => 'user_id',
                    Relation::OUTER_KEY => 'id',
                ],
            ],
        ],
    ],
]);
