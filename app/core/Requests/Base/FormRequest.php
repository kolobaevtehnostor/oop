<?php

namespace App\Core\Requests\Base;

use App\Core\Requests\Base\Request;

class FormRequest
{
    protected $request;
    
    protected $data = [];

    protected $allowedAttributes = [];

    protected static $instance;

    public function __construct() 
    {
        // рассказать про DI Container
        $this->request = Request::getInstance();

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

    /**
     * @return self
     * @throws RuntimeException
     */
    public static function getInstance(): self
    {
        if (! (static::$instance instanceof static)) {
            self::$instance = new static;
        }

        return static::$instance;
    }
}