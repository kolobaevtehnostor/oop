<?php

namespace App\Core\Requests\Base;

class Request
{
    protected $data = [];

    protected $allowAttributes = [];

    public function __construct(array $data) 
    {
        $this->load($data);
    }

    /**
     * Заполняет данные из запроса
     *
     * @return void
     */
    protected function load(array $data): void
    {
        foreach ($this->allowAttributes as $value) {

            if (array_key_exists($value, $data)) {
                $this->data[$value] = $data[$value];
            }
        }
    }

    /**
     * Возвращает атрибут
     * 
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key, $default = null) 
    {
        if (! isset($this->data[$key])) {
            return $default;
        }

        return $this->data[$key];
    }

    /**
     * Возвращает атрибуты
     * 
     * @param string $key
     * @return mixed
     */
    public function getData() 
    {

        return $this->data;
    }
}