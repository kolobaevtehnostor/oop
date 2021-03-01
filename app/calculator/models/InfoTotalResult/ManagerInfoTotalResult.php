<?php 

/** Кредитный калькулятор */
namespace App\Calculator\Models\InfoTotalResult;

use App\Calculator\Models\InfoTotalResult\Base\InfoTotalResult;

class ManagerInfoTotalResult extends InfoTotalResult
{
    public function printResult(): array
    {
        if (empty($this->allResultsCalculate)) {
            return [];
        }

        return $this->allResultsCalculate;
    }

}