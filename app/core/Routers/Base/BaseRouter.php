<?php

namespace App\Core\Routers\Base;

use App\Core\Requests\Base\Request;
use App\Core\Response;

abstract class BaseRouter
{

    /**
     * Правила роутов
     *
     * @return array
     */
    abstract protected function rules(): array;

    /**
     * Отправляет ответ
     *
     * @return Response
     */
    public function dispatch(Request $request): Response
    {
        $result = $this->getResult($request);

        $response = new Response();
        $response->setData($result);
        
        return $response;
    }


    protected function getResult(Request $request): string
    {
        $rules = $this->rules();

        if ($this->validationUrl($request->getUrl(), $rules)) {

            $controllerConfig = $rules[$request->getUrl()];
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

        return (string) $result;
    }

    /**
     * Проверка корректности url
     *
     * @return boolean
     * @throws NotFoundException
     */
    protected function validationUrl(string $url, array $rules): bool
    {
        $rules = $this->rules();

        if (! array_key_exists($url, $rules)) {

            throw new \Exception('Класс контроллера не найден');
        }
        
        return true;
    }

    /**
     * Запускает функцию контроллера
     *
     * @return void
     */
    protected function handleControllerAction($controller, $action, $request)
    {
        $result = $controller->{$action}($request);
    }
}