<?php

namespace App\Core;

class Response
{
    protected $data;
    
    public function setData(string $data)
    {
        $this->data = $data;
    }
    
    public function send(): void
    {
        echo $this->data;
    }
}