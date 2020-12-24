<?php

namespace App\Models\Animals\Base;

use App\Models\Base\EarthLifeForm;
use App\Models\EnergyGetterTypes\Hunting;
use App\Models\StateTypes\Growing;
use App\Models\RegenerationTypes\SexualReproduction;
use App\Models\StateTypes\Sleep;

abstract class Animal extends EarthLifeForm
{        
    public function getEnergyGetterTypes(): array
    {
        $hunting = new Hunting();

            return [$hunting];
    }

    public function getStateChangeTypes(): array
    {
        $growing = new Growing();
        $sleep = new Sleep();
        return [$growing, $sleep];
    }

    public function getRegenerationTypes(): array
    {
        $budding = new SexualReproduction();
        return [$budding];
    }
}