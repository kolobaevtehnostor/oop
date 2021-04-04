<?php

namespace App\Core;

use App\Routers\Router;
use App\Core\Response;
use App\Core\Requests\Base\Request;
use App\Exceptions\ErrorHandler;

class Kernel
{
    public function __construct(Router $router)
    {
        $this->router = $router;
        
        new Routes();
    }
    
    protected function dispatchByRouter(Request $request): Response
    {
        try {

            return $this->router->dispatch($request);
            
        } catch (\Throwable $error) {
            $errorHandler = new ErrorHandler();
            
            $result = $errorHandler->getResult($error);
            
            $response = new Response();
            
            $response->setData($result);
            
            return $response;
        }
    }
    
    public function handle(Request $request): Response
    {
        return $this->dispatchByRouter($request);
    }
}