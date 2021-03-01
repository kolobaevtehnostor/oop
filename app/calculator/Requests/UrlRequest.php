<?php

namespace App\Calculator\Requests;

class UrlRequest
{
    const ATTRIBUTE_CONTROLLER = 'c';
    const ATTRIBUTE_ACTION = 'a';

    protected $data = [];

    protected $attributes = [
        self::ATTRIBUTE_CONTROLLER => 'Calculator',
        self::ATTRIBUTE_ACTION => 'Show',
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