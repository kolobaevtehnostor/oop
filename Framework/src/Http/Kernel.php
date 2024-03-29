<?php

namespace Framework\Http;

use Framework\Routers\Router;
use Framework\Http\Responses\Response;
use Framework\Http\Requests\Base\Request;
use Framework\Exceptions\Handlers\ErrorHandler;
use App\Config\Routes;

class Kernel
{
    protected $router;

    public function __construct(Router $router)
    {
        $this->router = $router;
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