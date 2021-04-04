<?php

namespace App\Core;

class Web {

    private static $instance;

    protected static $config = [];
    protected static $routs = [];

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

    /**
     * Получает конфиг
     *
     * @param string $key
     * @return void
     */
    public static function getConfig(string $key)
    {
        return static::$config[$key];
    }

    /**
     * Записывает роуты
     *
     * @param string $link
     * @param string $controller
     * @param string $action
     * @param array $middleware
     * @return void
     */
    public function setRouts(
        string $link,
        string $controller,
        string $action,
        array  $middleware): void
    {
        static::$config[$link] = [
            'controller' => $controller,
            'action'     => $action,
            'middleware' => $middleware,
        ];
    }

} 