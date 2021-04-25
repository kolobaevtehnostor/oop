<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

define('ROOT_PATH', __DIR__ . '/../');

require_once ROOT_PATH . 'vendor/autoload.php';
require_once ROOT_PATH . 'Framework/src/Helpers/function.php';

use Framework\Routers\Router;
use Framework\Http\Requests\Base\Request;
use Framework\Http\Kernel;

$routes = include(ROOT_PATH . 'routes/web.php');

$router = new Router();

$router->setRoutes($routes);

$kernel = new Kernel($router);

$request = new Request($_SERVER, $_GET, $_POST);

$response = $kernel->handle($request);

$response->send();

exit();