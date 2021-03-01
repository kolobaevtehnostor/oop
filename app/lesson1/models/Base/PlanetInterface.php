<?php

namespace App\Models\Base;

interface PlanetInterface
{
    public function printLifeFormsName(): string;
    
    public function printLifeFormsDescription(): string;
}