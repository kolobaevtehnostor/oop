<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\BaseStrategy;
use App\Components\Calculator\CalculatorComponent;
use Framework\Models\Base\BaseModel;
use App\Models\GridInstallment;

class CalculateStrategyInstallment extends BaseStrategy
{
    public function __construct() 
    {
        $this->model = new GridInstallment;
    }

    function calculate(CalculatorComponent $calc): CalculatorComponent
    {
        $calc->costForPeriodSeller  = $calc->costMonth * $calc->period;;
        $calc->monthlySellerPayment = ceil($calc->costForPeriodSeller / $calc->period);
        
        $calc->costForPeriodClient  = $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
    }

  
}