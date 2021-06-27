<?php

namespace Framework\Config;
use Framework\Componensts\Singletons;

class Configuration extends Singletons
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
        $folderFiles = scandir($dir);

        foreach ($folderFiles as $key => $value)
        {
            if (! in_array($value,array('.', '..'))) {
                $configFileParams = include($dir . '/' . $value);
                $this->params = array_merge($this->params, $configFileParams); 
            }
        }
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