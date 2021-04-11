<?php

namespace App\Core\Routers\Base;

use App\Core\Requests\Base\Request;
use App\Core\Response;
use App\Core\Responses\JsonResponse;

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

        $response->setData($result);
        
        return $response;
    }

    protected function getResult(Request $request)
    {
        $routes = $this->routes();

        if ($this->validationUrl($request->server('PHP_SELF'), $routes)) {

            $controllerConfig = $routes[$request->server('PHP_SELF')];
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
     * Запускает функцию контроллера
     *
     * @return void
     */
    protected function handleControllerAction($controller, $action, $request) // : bool
    {
      return $controller->{$action}($request);
    }
}