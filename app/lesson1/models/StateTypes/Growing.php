<?php

namespace App\Models\StateTypes;

use App\Models\StateTypes\Base\StateChangeType;

class Growing extends StateChangeType
{
    public function getType(): string
    {
     
        return 'Растет';
    }
}