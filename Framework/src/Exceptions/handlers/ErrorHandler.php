<?php

namespace Framework\Exceptions\Handlers;

use Framework\Exceptions\NotFoundException;
use Framework\Views\View;
use Framework\Log;

class ErrorHandler
{
    public function getResult(\Throwable $error)
    {
        if ($error instanceof BadRequestException) {
            Log::error($error->getFile() . ': ' . $error->getLine() . ' -- ' . $error->getMessage());

            return $error->getMessage() . '. Обратитесь к администратору системы.';
        }
        
        if ($error instanceof NotFoundException) {
            Log::error($error->getFile() . ': ' . $error->getLine() . ' -- ' . $error->getMessage());

            return $error->getMessage() . '. Перейдите на главную страницу каталога.';
        }
        
        if ($error instanceof \Throwable) {
            Log::error($error->getFile() . ': ' . $error->getLine() . ' -- ' . $error->getMessage());

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