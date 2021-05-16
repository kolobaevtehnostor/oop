<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\BaseStrategy;
use App\Components\Calculator\CalculatorComponent;
use App\Models\GridLoan;

class CalculateStrategyLoan extends BaseStrategy
{
    public function __construct() 
    {
        $this->model = new GridLoan;
    }

    function calculate(CalculatorComponent $calc): CalculatorComponent
    {

        $calc->costForPeriodSeller  = 0;
        $calc->monthlySellerPayment = 0;

        $calc->costForPeriodClient  = (($calc->costMonth) * $calc->period) + $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
    }

    
}