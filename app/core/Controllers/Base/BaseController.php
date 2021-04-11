<?php

namespace App\Core\Controllers\Base;

use App\Core\Requests\Base\Request;
use App\Core\Responses\JsonResponse;

class BaseController
{

    protected function json(array $data): JsonResponse
    {
        return new JsonResponse($data);
    }

    protected function view(string $viewFile, string $folder = null)
    {
        if (! isset($folder)) {

            $className = (new \ReflectionClass($this))->getShortName();
            $folder = str_replace('Controller', '', $className);
        }
        
        $request = Request::getInstance();
        $patch = ($request->server('DOCUMENT_ROOT'));
        $view = file_get_contents($patch . '//../App//Views//' . $folder . '//' . $viewFile . '.php');

        return $view;
    }
}