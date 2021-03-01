<?php

namespace App\Config;

use App\Config\ConfigService;

class ConfigPorecessor
{
    public function getValue(string $key)
    {
        return ConfigService::getValueSetting($key);
    }
    
}