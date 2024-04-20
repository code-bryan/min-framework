<?php

declare(strict_types= 1);

define("BASE_PATH", dirname(__DIR__));
require_once dirname(__DIR__) . '/vendor/autoload.php';

$client = Illuminare\Client::index();

$controller = new App\Controllers\HomeController();

echo "{$controller->index()} {$client}";