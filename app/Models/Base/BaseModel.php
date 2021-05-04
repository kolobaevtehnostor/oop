<?php

namespace App\Models\Base;

class BaseModel 
{
    protected $builder = [];

    protected static $instance;

    /**
     *
     * @return void
     */
    public static function getInstance()
    {
        if (! (static::$instance instanceof static)) {
            static::$instance = new static();
        }
        
        return static::$instance;
    }

    /**
     * Получаем сокуп метод
     *
     * @param string $name
     * @return string
     */
    protected static function getScopeMethod(string $name): string
    {
        return 'scope' . ucfirst($name);
    }

    /**
     * Проверка на наличие скоупа
     *
     * @param string $name
     * @return boolean
     */
    protected static function hasScope(string $name): bool
    {
        $reflection = new \ReflectionClass(static::class);
        
        $scope = static::getScopeMethod($name);
        
        return $reflection->hasMethod($scope);
    }

    /**
     * Магия
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public function __call(string $name, $arguments)
    {
        
        if (static::hasScope($name)) {
            
            $instance = static::getInstance();
            
            $scope = static::getScopeMethod($name);
            
            $instance->{$scope}($this, ...$arguments);
            
            return $instance;
        }
    }

    /**
     * Магия
     *
     * @param string $name
     * @param array $arguments
     * @return void
     */
    public static function __callStatic(string $name, $arguments)
    {
        
        if (static::hasScope($name)) {
            
            $instance = static::getInstance();
            
            $scope = static::getScopeMethod($name);
            
            $instance->{$scope}($instance, ...$arguments);
            
            return $instance;
        }
    }

    /**
     * Делает выборку
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    protected function where(string $key, string $operator, string $value)
    {
        foreach ($this->builder as $idKey => $row) {

            eval('$executionResult = $row[$key] ' . $operator . ' $value;');

            if (! $executionResult) {
                unset($this->builder[$idKey]);
            }
        }

        return $this;
    }

    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
    public function findOneToArray()
    {
        return current($this->builder);
    }
    
    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
    public function findAllToArray()
    {
        return $this->builder;
    }
}