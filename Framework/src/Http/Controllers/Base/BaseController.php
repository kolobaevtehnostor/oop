<?php

namespace Framework\Http\Controllers\Base;

use Framework\Http\Requests\Base\Request;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\View;

class BaseController
{

    protected function json(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    /**
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