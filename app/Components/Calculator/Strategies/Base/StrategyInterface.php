<?php 

namespace App\Components\Calculator\Strategies\Base;

use App\Components\Calculator\CalculatorComponent;

interface StrategyInterface
{
    
    /**
     * Производит расчет калькулятора
     *
     * @param array $calc
     * @return array
     */
    function calculate(array $attributes = []): array;
}