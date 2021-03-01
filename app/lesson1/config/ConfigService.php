<?php

namespace App\Config;

class ConfigService
{
    private static $instance;

    private $configSetting = [];

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

    public static function getInstance(): self
    {
        if (! (static::$instance instanceof static)) {
            self::$instance = new static();
        }

        return self::$instance;
    }

    /**
     * Возвращает значение конфига
     *
     * @return string
     */
    public static function getValueSetting(string $key): string
    {
        $instance = static::getInstance();
      
        return $instance->getValue($key);
    }

    /**
     * Устанавливает значение конфига
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public static function setValueSetting(string $key, string $value): void
    {
        $instance = static::getInstance();
      
        $instance->setValue($key, $value);
    }

    /**
     * Возвращает значение конфига
     *
     * @param string $key
     * @param string $default
     * @return string
     */
    public function getValue(string $key, string $default = 'Свойство неизвестно'): string
    {
        return isset ($this->configSetting[$key]) ? $this->configSetting[$key] : $default;
    }

    /**
     * Устанавливает значение конфига
     *
     * @param string $key
     * @param string $value
     * @return void
     */
    public function setValue(string $key, string $value): void
    {
        $this->configSetting[$key] = $value;
    }

}