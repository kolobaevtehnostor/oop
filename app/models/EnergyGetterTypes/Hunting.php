<?php

namespace App\Models\EnergyGetterTypes;

use App\Models\EnergyGetterTypes\Base\EnergyGetterType;

class Hunting extends EnergyGetterType
{
    public function getType(): string
    {
     
        return 'Охота';
    }
}