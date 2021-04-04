<?php

namespace App\Config;

use App\Core\Web;
use App\Controllers\CalculatorController;
use App\Middleware\Only555Id;
use App\Middleware\AdminOnlyMiddleWare;

class Routes {

    public function __construct()
    {
        $this->setRouts();
    }

    /**
     *
     * @return void
     */
    protected function setRouts(): void
    {
        Web::setRoute('/index.php/calculator',
            CalculatorController::class,
            'show',
            [
                AdminOnlyMiddleWare::class,
                Only555Id::class,
            ]
        );
        
        Web::setRoute('/index.php/calculator/calculate',
            CalculatorController::class,
            'calculate'
        );
    }
}