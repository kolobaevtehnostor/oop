<?php

namespace Framework\Components;

class Singletons
{
    //protected static $instance;
    private static $instances = [];

    /**
     *
     * @return self
     */
    public static function getInstance(): self
    {
        $cls = static::class;

        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
        }

        return self::$instances[$cls];
        /*
        if (! static::$instance instanceof static) {
            
            static::$instance = new static();
        }

        return static::$instance;
        */
    }
}