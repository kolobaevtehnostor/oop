<?php

namespace App\Models\StateTypes;

use App\Models\StateTypes\Base\StateChangeType;

class Think extends StateChangeType
{
    public function getType(): string
    {
     
        return 'Думает';
    }
}