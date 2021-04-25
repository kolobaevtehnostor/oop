<?php

namespace App\Middleware;

use Framework\Http\Requests\Base\Request;
use Framework\Exceptions\BadRequestException;

class AdminOnlyMiddleWare
{
    public function handle(Request $request)
    {
        if ((string) $request->get('userRole') !== 'Admin') {
            throw new BadRequestException('Вы должны быть администратором системы!');
        }
    }
}