<?php
/** Абстрактный класс калькулятор */ 

namespace App\Calculator\Models\Base;

use App\Calculator\Models\InfoTotalResult\Base\InfoTotalResult;
use App\Calculator\Models\Grid;

abstract class Calculator
{
    /** Сумма, рублей */
    protected $amount;

    /** Период, мес. */
    protected $period;
    
    /** Первоначальный взнос, руб. */
    protected $downPayment;
    
    /** Годовая ставка процентная, проценты */
    protected $annualInterestRate;

    public function __construct(int $amount, int $period, int $downPayment, float $annualInterestRate) 
    {
        $this->amount = $amount;
        $this->period = $period;
        $this->downPayment = $downPayment;
        $this->annualInterestRate = $annualInterestRate;
    }

    public static function getIdentity(int $amount, int $period, int $downPayment): ?self
    {
        $grid = new Grid($amount, $period, $downPayment);
        
        if ( $grid->getPercent() < 0)
        {
            return null;
        }
                
        $annualInterestRate = $grid->getPercent();

        return new static($amount, $period, $downPayment, $annualInterestRate);
    }

    /**
     * Переплата по процентам, рублей
     *
     * @return integer
     */
    public function getInterestOverpayment(): int
    {
        return $this->amount / 100 * $this->annualInterestRate;
    }

    /**
     * Стоимость кредита в общая
     *
     * @return integer
     */
    public function getTotalCost(): int
    {
        return $this->amount - $this->downPayment + $this->getInterestOverpayment();
    }

    /**
     * Стоимость кредита в общая
     *
     * @return integer
     */
    public function getLoanCostMonth(): int
    {
        return ceil($this->getInterestOverpayment() / 12);
    }

    abstract protected function getTotalResult(): InfoTotalResult ;
}