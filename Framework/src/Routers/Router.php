<?php

namespace Framework\Routers;

use Framework\Routers\Base\BaseRouter;


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