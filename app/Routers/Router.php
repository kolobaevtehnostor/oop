<?php

namespace App\Routers;

use App\Core\Routers\Base\BaseRouter;
use App\Controllers\CalculatorController;
use App\Middleware\Only555Id;
use App\Middleware\AdminOnlyMiddleWare;
use App\Config\Routes;
use App\Core\Web;

class Router extends BaseRouter
{
    protected $routes = [];
    /**
     * Правила роутов
     *
     * @return array
     */
    public function routes(): array
    {       
        return $this->routes;
    }

    public function setRoutes(array $routes) {

        $this->routes = $routes; 
    }

}