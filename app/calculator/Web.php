<?php

namespace App\Calculator;

class Web {

    private static $instance;

    protected static $config = [
        'pathController' => 'App\\Calculator\\Controllers\\'
    ];

    /**
     * Конструктор Одиночки всегда должен быть скрытым, чтобы предотвратить
     * создание объекта через оператор new.
     */
    protected function __construct() { }

    /**
     * Одиночки не должны быть клонируемыми.
     */
    protected function __clone() { }

    /**
     * Одиночки не должны быть восстанавливаемыми из строк.
     */
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    /**
     * Создает или возвращает
     * единственный экземпляр класса
     *
     * @return self
     */
    public static function getInstance(): self
    {
        if (! (static::$instance instanceof static)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    
    public static function getConfig(string $key)
    {
        return static::$config[$key];
    }

    /**
     * Запускает action
     * из контроллера
     *
     * @param string $controllerName
     * @param string $action
     * @return void
     */
    public function startApp($controllerName = '', $action = ''): void
    {
        $controllerName = ucfirst($controllerName) . 'Controller';
        $useController = Web::getConfig('pathController') . $controllerName;

        $controller = new $useController();
        
        $controller->$action();
    }

} 