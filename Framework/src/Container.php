<?php

namespace Framework;

use Framework\Http\Requests\Base\Request;
use App\Requests\CreditRequest;

class Container
{
    protected static $instance;
    
    protected $singletons = [];
    
    protected function aliases(): array
    {
        return [
            Request::class => Request::class,
            CreditRequest::class => CreditRequest::class
        ];
    }
    
    /**
     * Возвращает singleton ключу
     *
     * @param string $key
     * @return object
     */
    public function get(string $key)//: object
    {
        if (isset($this->singletons[$key])) {

            return $this->singletons[$key];
        }
        
        $aliases = $this->aliases();

        $this->singletons[$key] = ($aliases[$key])::getInstance();
        
        return $this->singletons[$key];
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