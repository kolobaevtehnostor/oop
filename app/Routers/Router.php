<?php

namespace App\Routers;

use App\Core\Routers\Base\BaseRouter;
use App\Controllers\CalculatorController;
use App\Middleware\Only555Id;
use App\Middleware\AdminOnlyMiddleWare;

class Router extends BaseRouter
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