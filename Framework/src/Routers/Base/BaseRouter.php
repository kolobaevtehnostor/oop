<?php

namespace Framework\Routers\Base;

use Framework\Http\Requests\Base\Request;
use Framework\Http\Responses\Response;
use Framework\Http\Responses\JsonResponse;
use Framework\Exception\HttpException;
use Framework\Exceptions\NotFoundException;
use Framework\Exceptions\Handlers\ErrorHandler;

abstract class BaseRouter
{
    /**
     * Правила роутов
     *
     * @return array
     */
    abstract protected function routes(): array;

    /**
     * Отправляет ответ
     *
     * @return Response
     */
    public function dispatch(Request $request): Response
    {
        $result = $this->getResult($request);

        $response = new Response();

        if ($result instanceof JsonResponse) {

            $response->setHeader('Content-Type', 'application/json');
            $response->setData($result->getData());

            return $response;
        }   

        if ($result instanceof View) {

            $response->setData($result::__toString());

            return $response;
        }


        $response->setData($result);
        
        return $response;
    }

    /**
     * Проверка корректности url
     *
     * @return boolean
     * @throws NotFoundException
     */
    protected function validationUrl(string $url, array $routes): bool
    {
        if (! array_key_exists($url, $routes)) {

            throw new \Exception('Класс контроллера не найден');
        }
        
        return true;
    }

    /**
     *
     * @param Request $request
     * @return void
     */
    protected function getResult(Request $request)
    {
        $urlPath = $request->getUrlPath();
        
        $routes = $this->routes();

        if ($this->validationUrl($urlPath, $routes)) {

            $controllerConfig = $routes[$urlPath];
        }

        try {
            if (isset ($controllerConfig['middleware'])) {

                foreach ($controllerConfig['middleware'] as $middleware) {
                    
                    (new $middleware)->handle($request);
                }
            }
            
            $controller = new $controllerConfig['controller'];
            $action = $controllerConfig['action'];
            $result = $this->handleControllerAction($controller, $action, $request);

            
        } catch (\HttpException $error) {
            
            $errorHandler = new ErrorHandler();
            
            $result = $errorHandler->getResult($error);
            
        }

        return $result;
    }

    /**
     * Запускает функцию контроллера
     *
     * @return void
     */
    protected function handleControllerAction($controller, $action, $request) // : bool
    {
      return $controller->{$action}($request);
    }
}