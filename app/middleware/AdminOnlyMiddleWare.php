<?php

namespace App\Middleware;

use App\Core\Requests\Base\Request;
use App\Exceptions\BadRequestException;

class AdminOnlyMiddleWare
{
    public function handle(Request $request)
    {
        if ((string) $request->getParam('userRole') !== 'Admin') {
            throw new BadRequestException('Вы должны быть администратором системы!');
        }
    }
}