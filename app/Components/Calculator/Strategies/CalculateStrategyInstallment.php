<?php 

namespace App\Components\Calculator\Strategies;

use Framework\Components\Strategies\Base\BaseStrategy;
use App\Components\Calculator\CalculatorComponent;
use Framework\Models\Base\BaseModel;
use App\Models\GridInstallment;
use Framework\Components\Strategies\Base\StrategyInterface;

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
        $data = [
            'costForPeriodSeller'  => $attributes['costMonth'] * $attributes['period'],
            'costForPeriodClient'  => $attributes['totalAmount']
        ];

        return [
            'costForPeriodSeller'  => $data['costForPeriodSeller'],
            'monthlySellerPayment' => ceil($data['costForPeriodSeller'] / $attributes['period']),
            'costForPeriodClient'  => $data['costForPeriodClient'],
            'monthlyClientPayment' => ceil($data['costForPeriodClient'] / $attributes['period']),
        ];
    }

  
}