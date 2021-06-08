<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\BaseStrategy;
use App\Components\Calculator\CalculatorComponent;
use App\Models\GridLoan;
use App\Components\Calculator\Strategies\Base\StrategyInterface;

class CalculateStrategyLoan extends BaseStrategy implements StrategyInterface
{
    public function __construct() 
    {
        $this->model = new GridLoan;
    }

    /**
     * Производит расчет калькулятора
     *
     * @param array attributes
     * @return CalculatorComponent
     */
    function calculate(array $attributes = []): array
    {
     //   dd($attributes);
        return [
            'costForPeriodSeller'  => 0,
            'monthlySellerPayment' => 0,
            'costForPeriodClient'  => (($attributes['costMonth']) * $attributes['period']) + $attributes['totalAmount'],
            'monthlyClientPayment' => ceil($attributes['costForPeriodClient'] / $attributes['period']),
        ];
    }

    
}