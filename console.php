<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

define('ROOT_PATH', __DIR__ . '/./');

require_once 'vendor/autoload.php';
require_once 'Framework/src/Helpers/function.php';

use Framework\Console\Kernel;
use Framework\Console\ConsoleInputHandler;
use Framework\Http\Requests\Base\RequestInterface;
use Framework\Config\Configuration;

$routes = include('routes/console.php');

$kernel = new Kernel($routes);

$request = new ConsoleInputHandler($_SERVER, $argv);

bind(RequestInterface::class, $request);

$status = $kernel->handle($request);

exit($status);