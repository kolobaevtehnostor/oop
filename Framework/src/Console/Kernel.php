<?php

namespace Framework\Console;

/*
use Framework\Routers\Router;
use Framework\Http\Responses\Response;
use Framework\Http\Requests\Base\Request;
use Framework\Exceptions\Handlers\ErrorHandler;
use App\Config\Routes;
*/

use Framework\Http\Requests\Base\RequestInterface;

class Kernel
{
    protected $router;

    public function __construct(array $router = [])
    {
        $this->router = $router;
    }
    
    protected function startCommand(RequestInterface $request): string
    {
        try {
            $command = new $this->router[$request->getComandName()];

            $command->handle($request);

            return $command->getMessage();
            
        } catch (\Throwable $error) {

            return $error->getMessage();

           /*
            $errorHandler = new ErrorHandler();
            
            $result = $errorHandler->getResult($error);
            
            $response = new Response();
            
            $response->setData($result);
            
            return $response;
            */
        }

    }
    
    public function handle(RequestInterface $request): string
    {
       return $this->startCommand($request);
    }
}