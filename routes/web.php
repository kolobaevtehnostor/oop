<?php

use App\Controllers\DefaultController;
use App\Controllers\CalculatorController;
use App\Middleware\Only555Id;
use App\Middleware\AdminOnlyMiddleWare;

return [
    '/index.php/calculator' => [
        'controller' => CalculatorController::class,
        'action'    => 'actionShow',
        'middleware' => [
            AdminOnlyMiddleWare::class,
            Only555Id::class,
        ],
    ],
    '/index.php/calculator/calculate' => [
        'controller' => CalculatorController::class,
        'action'    => 'actionCalculate',
    ],
    '/index.php/' => [
        'controller' => DefaultController::class,
        'action'    => 'actionShow',
    ],
];