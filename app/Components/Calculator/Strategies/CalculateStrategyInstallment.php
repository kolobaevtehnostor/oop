<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\StrategyInterface;
use App\Components\Calculator\CalculatorComponent;

class CalculateStrategyInstallment implements StrategyInterface
{
    function calculate(CalculatorComponent $calc): CalculatorComponent
    {

        $calc->costForPeriodSeller = $calc->costMonth * $calc->period;;
        $calc->monthlySellerPayment = ceil($calc->costForPeriodSeller / $calc->period);
        
        $calc->costForPeriodClient = $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
    }
}