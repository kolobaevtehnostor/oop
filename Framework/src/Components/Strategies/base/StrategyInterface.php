<?php 

namespace Framework\Components\Strategies\Base;

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