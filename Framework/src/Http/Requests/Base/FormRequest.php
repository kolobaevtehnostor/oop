<?php

namespace Framework\Http\Requests\Base;

use Framework\Http\Requests\Base\RequestInterface;
use Framework\Components\Singletons;

class FormRequest extends Singletons
{
    protected $request;
    
    protected $data = [];

    protected $allowedAttributes = [];

    protected static $instance;

    public function __construct() 
    {
        $this->request = app(RequestInterface::class);

        $this->load();
    }

    /**
     * Заполняет данные из запроса
     *
     * @return void
     */
    protected function load(): void
    {
        foreach ($this->allowedAttributes as $value) {

            if ($this->request->isByGet($value)) {
                $this->data[$value] = $this->request->get($value);
                continue;
            }
            
            if ($this->request->isByPost($value)) {
                $this->data[$value] = $this->request->post($value);
                continue;
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