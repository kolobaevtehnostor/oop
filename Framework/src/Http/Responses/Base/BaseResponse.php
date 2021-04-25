<?php

namespace Framework\Http\Responses\Base;

class BaseResponse
{
    protected $headers = [];
    
    protected $data;

    public function setHeader(string $key, string $value)
    {
        $this->headers[$key] = $value;
    }
    
    /**
     * @param mixed $data
     * @return void
     */
    public function setData($data)
    {
        $this->data = $data;
    }
    
    public function send(): void
    {
        foreach ($this->headers as $key => $value) {
            header($key . ': ' . $value);
        }

        if (is_array($this->data)) {
            $this->data = json_encode($this->data);
        }

        echo $this->data;
    }
}