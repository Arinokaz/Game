<?php

use Spiral\Database;
use Spiral\Database\Driver\MySQL\MySQLDriver;

return new Database\DatabaseManager(
    new Database\Config\DatabaseConfig([
        'default'     => 'default',
        'databases'   => [
            'default' => ['connection' => 'mysql']
        ],
        'connections' => [
            'mysql'     => [
                'driver'  => MySQLDriver::class,
                'options' => [
                    'connection' => 'mysql:host=db-game;port=3306;dbname=project',
                    'username'   => 'root',
                    'password'   => '123456',
                ]
            ],
        ]
    ])
);
