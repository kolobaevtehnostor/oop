<?php

namespace Framework\Command;

class CommandContext 
{
    protected $params = [];

    /**
     * Установка значения параметра по ключу
     *
     * @param string $key
     * @param $value
     * @return void
     */
    public function setParam(string $key, $value): void
    {
        $this->params[$key] = $value;
    }

    /**
     * Получение значения параметра по ключу
     *
     * @param string $key
     * @return void
     */
    public function getParam(string $key, $default='-')
    {
        if (isset($this->params[$key])) {

            return $this->params[$key];
        }

        return $default;
    }

    /**
     * Получение свойства параметра
     *
     * @param string $key
     * @return void
     */
    public function getParamProperty(string $key, string $property)
    {
        $option = $this->getParam($key);

        if ($option && isset($option[$property])) {

            return $option[$property];
        }

        return null;
    }
}
