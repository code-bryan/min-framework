<?php

declare(strict_types= 1);

define("BASE_PATH", dirname(__DIR__));
define("BASE_CONTROLLERS_PATH", dirname(__DIR__) . '/app/Controllers');
require_once dirname(__DIR__) . '/vendor/autoload.php';

use Illuminare\Foundation\Kernel;

$kernel = new Kernel();
$kernel->handle();