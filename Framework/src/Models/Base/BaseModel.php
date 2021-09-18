<?php

namespace Framework\Models\Base;

use Framework\Models\Builder\Builder;
use Framework\Components\Singletons;
use Framework\Config\Configuration;

abstract class BaseModel extends Singletons
{
    protected $tableName;

    protected $builder;

    protected static $instance;

    /**
     * Возвращает название
     *
     * @return string
     */
    abstract function getTableName(): string;

    public function __construct() 
    {
        $this->tableName = $this->getTableName();
        
        $data = getConfig('grid_' . $this->tableName);
        
        $this->builder = new Builder($data);
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
     * Возвращает json из файла
     * в виде массива php
     *
     * @param string $nameFile
     * @param string $pathFile
     * @return void
     */
    protected function getJsonToArray(
        string $pathFile = ROOT_PATH . '/app/components/calculator/'): array
    {
        $date = file_get_contents($pathFile . $this->tableName . '.json' );
        return (array) json_decode($date, true);
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
        $this->builder->where($key, $operator, $value);

        return $this;
    }

    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
    public function findOne()
    {
        return $this->builder->findOne();
    }
    
    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
 
    public function findAll()
    {
        return $this->builder->findAll();
    }
    
}