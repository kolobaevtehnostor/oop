<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Routers\Router;
use App\Core\Requests\UrlRequest;
use App\Core\Kernel;

$router = new Router();

$kernel = new Kernel($router);

$request = new UrlRequest();

$response = $kernel->handle($request);

$response->send();



