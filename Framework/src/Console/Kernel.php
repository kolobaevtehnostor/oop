<?php

namespace Framework\Console;

/*
use Framework\Routers\Router;
use Framework\Http\Responses\Response;
use Framework\Http\Requests\Base\Request;
use Framework\Exceptions\Handlers\ErrorHandler;
use App\Config\Routes;
*/

class Kernel
{
    protected $commandClass;

    public function __construct(string $commandClass)
    {
        $this->commandClass = $commandClass;
    }
    
    protected function startCommand(array $attr = []): string
    {
        try {

            $command = new $this->commandClass;
            $command->handle($attr);

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
    
    public function handle(array $attr = []): string
    {
       return $this->startCommand($attr);
    }
}