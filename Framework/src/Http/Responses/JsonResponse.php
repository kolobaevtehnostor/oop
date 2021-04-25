<?php

namespace Framework\Http\Responses;

use Framework\Http\Responses\Base\BaseResponse;

class JsonResponse extends BaseResponse
{
    protected $data;
    
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }
}