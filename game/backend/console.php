#!/usr/bin/env php
<?php

$container = require __DIR__ . '/bootstrap.php';

use app\commands\PrizeHandlerCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new PrizeHandlerCommand($orm));

$application->run();