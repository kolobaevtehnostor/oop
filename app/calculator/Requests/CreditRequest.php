<?php

namespace App\Calculator\Requests;

class CreditRequest
{
    protected $data = [];

    const ATTRIBUTE_TOTAL_AMOUNT = 'totalAmount';
    
    protected $attributes = [
        self::ATTRIBUTE_TOTAL_AMOUNT => 0,
        'period'      => 0,
        'initialFee'  => 0
    ];

    public function __construct(array $data) 
    {
        $this->data = $data; 
        $this->load();
    }

    protected function load(): void
    {
        foreach ($this->attributes as $key => $value) {
            if (! isset($this->data[$key])) {
                continue;
            }

            $this->attributes[$key] = $this->data[$key];
        }
    }
    
    public function hasData(): bool
    {
        return (bool) count($this->data);
    }

    /**
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
    
}