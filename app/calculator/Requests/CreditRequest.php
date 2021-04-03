<?php

namespace App\Calculator\Requests;

class CreditRequest
{
    protected $data = [];

    const ATTRIBUTE_TOTAL_AMOUNT = 'totalAmount';
    const ATTRIBUTE_PERIOD = 'period';
    const ATTRIBUTE_INITIAL_FEE = 'initialFee';
    const ATTRIBUTE_TYPE = 'typeCalculator';
    
    protected $attributes = [
        self::ATTRIBUTE_TOTAL_AMOUNT => 0,
        self::ATTRIBUTE_PERIOD => 0,
        self::ATTRIBUTE_INITIAL_FEE => 0,
        self::ATTRIBUTE_TYPE => 'loan'
    ];

    public function __construct(array $data) 
    {
        $this->data = $data; 
        $this->load();
    }

    /**
     * Загружает атрибуты
     *
     * @return void
     */
    protected function load(): void
    {
        foreach ($this->attributes as $key => $value) {
            if (! isset($this->data[$key])) {
                continue;
            }

            $this->attributes[$key] = $this->data[$key];
        }
    }
    
    /**
     * Проверяет наличие
     * данных запроса
     *
     * @return boolean
     */
    public function hasData(): bool
    {
        return (bool) count($this->data);
    }

    /**
     * Возвращает атрибут
     * 
     * @param string $key
     * @return mixed
     */
    public function getAttribute(string $key, $default = null) 
    {
        if (! isset($this->attributes[$key])) {
            return $default;
        }

        return $this->attributes[$key];
    }

    /**
     * Возвращает атрибут
     * 
     * @param string $key
     * @return mixed
     */
    public function getAttributesAsArray(string $key, $default = null) 
    {
        if (! isset($this->attributes[$key])) {
            return $default;
        }

        return $this->attributes;
    }
    
}