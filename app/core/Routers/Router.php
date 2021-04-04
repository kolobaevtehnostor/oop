<?php

namespace App\Core\Routers;

use App\Core\Routers\Base\MainRouter;
use App\Controllers\CalculatorController;
use App\Middleware\Only555Id;
use App\Middleware\AdminOnlyMiddleWare;

class Router extends MainRouter
{
    /**
     * Правила роутов
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            '/index.php/calculator' => [
                'controller' => CalculatorController::class,
                'action'    => 'show',
                'middleware' => [
                    AdminOnlyMiddleWare::class,
                    Only555Id::class,
                ],
            ],
            '/index.php/calculator/calculate' => [
                'controller' => CalculatorController::class,
                'action'    => 'calculate',
            ],
        ];
    }

}