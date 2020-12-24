<?php

namespace App\Models\Plants\Base;

use App\Models\Base\EarthLifeForm;
use App\Models\EnergyGetterTypes\Photosynthesis;
use App\Models\StateTypes\Growing;
use App\Models\RegenerationTypes\Budding;

abstract class Plants extends EarthLifeForm
{
    public function getEnergyGetterTypes(): array
    {
        $photosynthesis = new Photosynthesis();

            return [$photosynthesis];
    }

    public function getStateChangeTypes(): array
    {
        $growing = new Growing();
        return [$growing];
    }

    public function getRegenerationTypes(): array
    {
        $budding = new Budding();
        return [$budding];
    }
}
