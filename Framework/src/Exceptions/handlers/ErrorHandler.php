<?php

namespace Framework\Exceptions\Handlers;

use Framework\Exceptions\NotFoundException;
use Framework\Views\View;

class ErrorHandler
{
    public function getResult(\Throwable $error)
    {
        if ($error instanceof BadRequestException) {

            return $error->getMessage() . '. Обратитесь к администратору системы.';
        }
        
        if ($error instanceof NotFoundException) {

            return $error->getMessage() . '. Перейдите на главную страницу каталога.';
        }
        
        if ($error instanceof \Throwable) {
            
            return View::compose(
                'errors/throwable', 
                [
                    'errorCode' => $this->printCodeError($error->getCode()),
                    'errorFile' => $error->getFile(),
                    'errorLine' => $error->getLine(),
                    'errorMessage' => $error->getMessage(),
                ]
            );
        }
    }

    protected function printCodeError(int $codeError, string $default = 'Критическая ошибка!'): string
    {
        return $codeError ?: $default;
    }
}