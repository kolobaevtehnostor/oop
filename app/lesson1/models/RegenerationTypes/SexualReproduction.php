<?php

namespace App\Models\RegenerationTypes;

use App\Models\RegenerationTypes\Base\RegenerationType;

class SexualReproduction extends RegenerationType
{
    public function getType(): string
    {
     
        return 'Половое размножение';
    }
}