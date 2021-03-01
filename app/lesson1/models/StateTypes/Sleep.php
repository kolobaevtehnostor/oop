<?php

namespace App\Models\StateTypes;

use App\Models\StateTypes\Base\StateChangeType;

class Sleep extends StateChangeType
{
    public function getType(): string
    {
     
        return 'Спит';
    }
}