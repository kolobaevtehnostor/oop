<?php

namespace App\Config;

class App {

    protected static $config = [];

    protected function __construct() { }
    protected function __clone() { }
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
}