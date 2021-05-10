<?php 

namespace App\Components\Calculator\Strategies\Base;

use App\Components\Calculator\CalculatorComponent;

interface StrategyInterface
{
    function calculate(CalculatorComponent $calc): CalculatorComponent;
}