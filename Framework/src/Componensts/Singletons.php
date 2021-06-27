<?php

namespace Framework\Componensts;

class Singletons
{
    protected static $instance;

    /**
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (! static::$instance instanceof static) {
            static::$instance = new static;
        }
        
        return static::$instance;
    }
}