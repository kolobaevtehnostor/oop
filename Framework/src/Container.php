<?php

namespace Framework;

use Framework\Http\Requests\Base\Request;
use App\Requests\CreditRequest;
use Framework\Components\Singletons;
use Framework\Http\Requests\Base\RequestInterface;
use Framework\Config\Configuration;

class Container extends Singletons
{
    protected static $instance;
    
    protected $singletons = [];
    
    protected function aliases(): array
    {
        return [
            RequestInterface::class       => RequestInterface::class,
            CreditRequest::class => CreditRequest::class,
            Configuration::class => Configuration::class,
        ];
    }
    
    /**
     * Возвращает singleton ключу
     *
     * @param string $key
     * @return object
     */
    public function get(string $key)
    {
        if (isset($this->singletons[$key])) {

            return $this->singletons[$key];
        }
        
        $aliases = $this->aliases();

        $this->singletons[$key] = new $aliases[$key];
        
        return $this->singletons[$key];
    }
    
    /**
     * Устанавливает объект по ключу
     *
     * @param string $key
     * @param object $object
     * @return void
     */
    public function bind(string $key, $object): void
    {
        $this->singletons[$key] = $object;
    }

}