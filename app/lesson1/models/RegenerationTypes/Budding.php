<?php

namespace App\Models\RegenerationTypes;

use App\Models\RegenerationTypes\Base\RegenerationType;

class Budding extends RegenerationType
{
    public function getType(): string
    {
     
        return 'Почкование';
    }
}