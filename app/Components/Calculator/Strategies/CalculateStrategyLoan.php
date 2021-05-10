<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\StrategyInterface;
use App\Components\Calculator\CalculatorComponent;

class CalculateStrategyLoan implements StrategyInterface
{
    function calculate(CalculatorComponent $calc): CalculatorComponent
    {
        $calc->costForPeriodSeller = 0;
        $calc->monthlySellerPayment = 0;

        $calc->costForPeriodClient = (($calc->costMonth) * $calc->period) + $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
    }
}