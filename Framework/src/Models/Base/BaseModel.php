<?php

namespace Framework\Models\Base;

use Framework\Models\Builder\PDO\Builder;
use Framework\Components\Singletons;
use Framework\Config\Configuration;
use Framework\Components\Connection;

abstract class BaseModel extends Singletons
{
    public $dtoModelClass;

    public $builder;

    protected $tableName;

    protected static $instance;

    /**
     * Возвращает название
     *
     * @return string
     */
    abstract function getTableName(): string;
    
    /**
     * Возвращает дто класс модели
     *
     * @return string
     */
    abstract function getModelDtoClass(): string;

    public function __construct() 
    {
        $this->tableName = $this->getTableName();

        $this->dtoModelClass = $this->getModelDtoClass();
        
        $this->builder = new Builder($this->tableName);
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
        $connect = new Connection();

        return $connect->select($this->builder, $this->getModelDtoClass())->one();
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
