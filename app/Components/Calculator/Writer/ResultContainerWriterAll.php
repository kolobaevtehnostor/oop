<?php 

namespace App\Components\Calculator\Writer;

use App\Components\Calculator\Writer\Base\ResultContainerInterface;

class ResultContainerWriterAll implements ResultContainerInterface
{
    protected $data = [];

    protected static $instance;

    public static function setData(array $attributes = []): void
    {
        $instance = static::getInstance();

        $instance->data = $attributes;
    }

    /**
     * выводит инфу
     *
     * @return array
     */
    public static function all(): array
    {
        $instance = static::getInstance();

        return $instance->data;
    }

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