<?php 

namespace App\Components\Calculator\Strategies;

use Framework\Components\Strategies\Base\BaseStrategy;
use Framework\Components\Strategies\Base\StrategyInterface;
use App\Components\Calculator\CalculatorComponent;
use App\Models\GridLoan;

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
        $data = [
            'costForPeriodClient'  => (($attributes['costMonth']) * $attributes['period']) + $attributes['totalAmount']
        ];

        return [
            'costForPeriodSeller'  => 0,
            'monthlySellerPayment' => 0,
            'costForPeriodClient'  => $data['costForPeriodClient'],
            'monthlyClientPayment' => ceil($data['costForPeriodClient'] / $attributes['period']),
        ];
    }

    
}