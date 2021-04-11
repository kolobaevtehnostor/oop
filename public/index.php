<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Routers\Router;
use App\Core\Requests\Base\Request;
use App\Core\Kernel;

$routes = include( __DIR__ . '/../' . 'routes/web.php');

$router = new Router();

$router->setRoutes($routes);

$kernel = new Kernel($router);

$request = new Request($_SERVER, $_GET, $_POST);

$response = $kernel->handle($request);

$response->send();

exit();