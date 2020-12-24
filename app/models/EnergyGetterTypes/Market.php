<?php

namespace App\Models\EnergyGetterTypes;

use App\Models\EnergyGetterTypes\Base\EnergyGetterType;

class Market extends EnergyGetterType
{
    public function getType(): string
    {
     
        return 'Покупает в магазине';
    }
}