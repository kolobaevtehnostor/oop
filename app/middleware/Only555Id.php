<?php

namespace App\Middleware;

use App\Core\Requests\Base\Request;
use App\Exceptions\NotFoundException;

class Only555Id
{
    public function handle(Request $request)
    {

        if ((int) $request->get('id') !== 555) {
            throw new NotFoundException('Не указан правильный id');
        }
    }
}
