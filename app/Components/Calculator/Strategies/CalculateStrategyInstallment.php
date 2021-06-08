<?php 

namespace App\Components\Calculator\Strategies;

use App\Components\Calculator\Strategies\Base\BaseStrategy;
use App\Components\Calculator\CalculatorComponent;
use Framework\Models\Base\BaseModel;
use App\Models\GridInstallment;
use App\Components\Calculator\Strategies\Base\StrategyInterface;

class CalculateStrategyInstallment extends BaseStrategy  implements StrategyInterface
{
    public function __construct() 
    {
        $this->model = new GridInstallment;
    }

    /**
     * Производит расчет калькулятора
     *
     * @param array $calc
     * @return array
     */
    function calculate(array $attributes = []): array
    {
        return [
            'costForPeriodSeller'  => $attributes['costMonth'] * $attributes['period'],
            'monthlySellerPayment' => ceil(attributes['costForPeriodSeller'] / $attributes['period']),
            'costForPeriodClient'  => $attributes['totalAmount'],
            'monthlyClientPayment' => ceil($attributes['costForPeriodClient'] / $attributes['period']),
        ];
    }

  
}