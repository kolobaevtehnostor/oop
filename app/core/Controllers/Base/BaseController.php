<?php

namespace App\Core\Controllers\Base;

use App\Core\Requests\Base\Request;
use App\Core\Responses\JsonResponse;
use App\Core\Views\View;

class BaseController
{

    protected function json(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
     * Undocumented function
     *
     * @param string $fileName
     * @param array $attributes
     * @return View
     */
    protected function render(string $fileName, array $attributes = []): View
    {
        return View::compose($fileName, $attributes);
    }
    
}