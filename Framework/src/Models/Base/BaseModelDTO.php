<?php

namespace Framework\Models\Base;

class BaseModelDTO
{
    protected $attributes = [];
    
    public function __set($name, $value)
    {
        if (in_array($name, $this->attributes))

        $this->{$name} = $value;
    }

}