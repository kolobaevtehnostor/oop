<?php /** Кредитный калькулятор */

namespace App\Calculator\Models;

use App\Calculator\Models\Base\Calculator;
use App\Calculator\Models\InfoTotalResult\Base\InfoTotalResult;
use App\Calculator\Models\InfoTotalResult\ManagerInfoTotalResult;

class LoanCalculator extends Calculator
{
    protected function getCalculate(): ManagerInfoTotalResult
    {
        $this->amount;
        $this->period;
        $this->downPayment;
        $this->annualInterestRate;

        // Стоимость кредита в месяц
        $loanCostMonth = $this->getLoanCostMonth();

        //Стоимость кредита за 6 месяцев
        $loanCostForPeriod = (($loanCostMonth) * $this->period) + $this->amount;

        //Стоимость кредита для клиента в месяц
        $monthlyPayment = ceil($loanCostForPeriod / $this->period);

        $infoResult = new ManagerInfoTotalResult();

        $infoResult->setResultsCalculate(
            [
               ['Процент:' => $this->annualInterestRate], 
               ['Первоначальный взнос:' => $this->downPayment], 
               ['Переплата по процентам, рублей:' => $this->getInterestOverpayment()], 
               ['Стоимость кредита в год:' => $this->getTotalCost()],
               ['Переплата кредита в месяц' => $loanCostMonth],
               ['Долг кредита за ' . $this->period . ' месяцев' => $loanCostForPeriod],
               ['Взнос клиента в месяц' =>  $monthlyPayment]
            ]
        );

        return $infoResult;
    }


    public function getTotalResult(): InfoTotalResult
    {
        return $this->getCalculate();
    }
}