<?php

namespace App\Models\SentientAnimal\Base;

use App\Models\Animals\Base\Animal;


use App\Models\EnergyGetterTypes\Market;
use App\Models\StateTypes\Growing;
use App\Models\StateTypes\Sleep;
use App\Models\StateTypes\Think;

abstract class SentientAnimal extends Animal
{
    public function getEnergyGetterTypes(): array
    {
        $market = new Market();

        return [$market];
    }

    public function getStateChangeTypes(): array
    {
        $growing = new Growing();
        $sleep = new Sleep();
        $sleep = new Think();

        return [$growing, $sleep];
    }
}