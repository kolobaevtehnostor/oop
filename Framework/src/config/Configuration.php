<?php

namespace Framework\Config;

class Configuration
{
    /**
     * @var array
     */
    protected $params = [];

    public function __construct() 
    {
        $this->dirToArray();
    }
    /**
     * Перебирает все файлы
     *
     * @param string $dir
     * @return void
     */
    function dirToArray(string $dir = ROOT_PATH . 'app/config'): void
    {
        $cdir = scandir($dir);

        foreach ($cdir as $key => $value)
        {
            if (!in_array($value,array(".","..")))
            {
                $configFileParams = include($dir . '/' . $value);
                $this->params = array_merge($this->params, $configFileParams); 
            }
        }
    }

    /**
     * @return self
     * @throws RuntimeException
     */
    public static function getInstance(): self
    {
        if (! (self::$instance instanceof self)) {
            throw new \RuntimeException('Объект запроса не инициализирован.');
        }

        return self::$instance;
    }

    /**
     * Возвращает параметр конфига
     *
     * @param string $key
     * @return mixed
     */
    public function getParam(string $key)
    {
        if (isset( $this->params[$key])) {

            return $this->params[$key];
        }

        throw new \Exception('Параметр конфига не найден');
    }

}