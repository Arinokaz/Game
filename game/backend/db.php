<?php

declare(strict_types=1);

use Cycle\ORM;

$dbal = require './connection.php';
$schemas = require './schemas.php';

$orm = new ORM\ORM(new ORM\Factory($dbal), $schemas);

return $orm;