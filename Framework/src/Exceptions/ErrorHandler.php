<?php

namespace Framework\Exceptions;

use Framework\Exceptions\NotFoundException;

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
            return "Ошибка ядра! \n" . $error->getMessage() . '. Обратитесь к отделу веб-разработки.';
        }
    }
}