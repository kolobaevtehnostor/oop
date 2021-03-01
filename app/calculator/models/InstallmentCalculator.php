<?php /** Калькулятор рассрочки */

namespace App\Calculator\Models;

use App\Calculator\Models\Base\Calculator;
use App\Calculator\Models\InfoTotalResult\Base\InfoTotalResult;
use App\Calculator\Models\InfoTotalResult\ManagerInfoTotalResult;

class InstallmentCalculator extends Calculator
{
    protected function getCalculate(): ManagerInfoTotalResult
    {
        $this->amount;
        $this->period;
        $this->downPayment;
        $this->annualInterestRate;

        // Стоимость в месяц
        $loanCostMonth = $this->getLoanCostMonth();

        //Стоимость кредита за 6 месяцев
        $loanCostForPeriod = ($loanCostMonth * $this->period);
        //Стоимость кредита для клиента в месяц
        $monthlyPayment = ceil($this->amount / $this->period);

        $infoResult = new ManagerInfoTotalResult();

        $infoResult->setResultsCalculate(
            [
               ['Процент:' => $this->annualInterestRate], 
               ['Переплата по процентам, рублей:' => $this->getInterestOverpayment()], 
               ['Долг клиента за ' . $this->period . ' месяцев' => $this->amount],
               ['Долг продавца за ' . $this->period . ' месяцев' => $loanCostForPeriod],
               ['Взнос клиента в месяц' =>  $monthlyPayment],
               ['Взнос продавца в месяц' =>  $loanCostMonth]
            ]
        );

        return $infoResult;
    }


    public function getTotalResult(): InfoTotalResult
    {
        return $this->getCalculate();
    }
}