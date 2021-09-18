<?php

namespace Framework\Config;
use Framework\Components\Singletons;

class Configuration extends Singletons
{
    /**
     * @var array
     */
    public $params = [
        'dir' => ROOT_PATH . 'app/config'
    ];

    public function __construct() 
    {
       // $this->setParamDir(ROOT_PATH . 'app/config');
       // $this->getParam('dir');
       // $this->dirToArray();
    }
    /**
     * Перебирает все файлы
     *
     * @param string $dir
     * @return void
     */
    public function dirToArray(): void
    {
        $folderFiles = scandir($this->getParam('dir'));

        foreach ($folderFiles as $key => $value)
        {
            if (! in_array($value,array('.', '..'))) {
                $configFileParams = include($this->getParam('dir') . '/' . $value);
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

    /**
     * Возвращает параметр конфига
     *
     * @param string $key
     * @return mixed
     */
    public function setParamDir(string $dir = ROOT_PATH . 'app/config')
    {
        $this->params['dir'] = $dir;
    }

}