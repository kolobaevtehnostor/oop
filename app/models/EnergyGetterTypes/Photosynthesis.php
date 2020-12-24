<?php

namespace App\Models\EnergyGetterTypes;

use App\Models\EnergyGetterTypes\Base\EnergyGetterType;

class Photosynthesis extends EnergyGetterType
{
    public function getType(): string
    {
     
        return 'Фотосинтез';
    }
}