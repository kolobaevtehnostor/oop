<?php 

namespace App\Components\Calculator;

class CalculatorComponent
{
    /**
     * Сумма, рублей
     * @var int
     */
    protected $amount;

    /** Период, мес.
     * @var int
     */
    protected $period;
    
    /** Первоначальный взнос, руб.
     * @var int
     */
    protected $downPayment;

    /** Стоимость кредита за период месяцев
     * @var int
     */
    protected $costForPeriod;

    /** Стоимость кредита за период месяцев (Клиент)
     * @var int
     */
    protected $costForPeriodClient;
    
    /** Стоимость кредита за период месяцев (Продавец)
     * @var int
     */
    protected $costForPeriodSeller;

    /** Стоимость кредита
     * @var int
     */
    protected $monthlyPayment;
    
    /** Годовая ставка процентная, проценты 
     * @var int
     */
   // protected $annualInterestRate;
    
    /** Стоимость кредита в месяц
     * @var int
     */
   // protected $costMonth;
    
    
    /** Стоимость кредита для клиента в месяц
     * @var int
     */
    protected $monthlyClientPayment;

    /** Стоимость кредита для продавца в месяц
     * @var int
     */
    protected $monthlySellerPayment;

    public function __construct(int $amount, int $period, int $downPayment, float $annualInterestRate) 
    {
        $this->amount             = $amount;
        $this->period             = $period;
        $this->downPayment        = $downPayment;
        $this->annualInterestRate = $annualInterestRate;

        $this->costMonth = $this->getCostMonth();
    }

    /**
     * Кредитный калькулятор
     *
     * @param integer $amount
     * @param integer $period
     * @param integer $downPayment
     * @param float $annualInterestRate
     * @return array
     */
    public static function calculateLoan(int $amount, int $period, int $downPayment, float $annualInterestRate): self
    {
        $calc = new static($amount, $period, $downPayment, $annualInterestRate);

        $calc->costForPeriodSeller = 0;
        $calc->monthlySellerPayment = 0;

        $calc->costForPeriodClient = (($calc->costMonth) * $calc->period) + $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
    }
    
    /**
     * Калькулятор рассрочки
     *
     * @param integer $amount
     * @param integer $period
     * @param integer $downPayment
     * @param float $annualInterestRate
     * @return array
     */
    public static function calculateInstallment(int $amount, int $period, int $downPayment, float $annualInterestRate): self
    {
        $calc = new static($amount, $period, $downPayment, $annualInterestRate);

        $calc->costForPeriodSeller = $calc->costMonth * $calc->period;;
        $calc->monthlySellerPayment = ceil($calc->costForPeriodSeller / $calc->period);
        
        $calc->costForPeriodClient = $calc->amount;
        $calc->monthlyClientPayment = ceil($calc->costForPeriodClient / $calc->period);

        return $calc;
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
     * Стоимость кредита в месяц
     *
     * @return integer
     */
    public function getCostMonth(): int
    {

        return ceil($this->getInterestOverpayment() / 12);
    }

     /**
     * Стоимость кредита общая
     *
     * @return integer
     */
    public function getTotalCost(): int
    {
        return $this->amount - $this->downPayment + $this->getInterestOverpayment();
    }

    /**
     * Возвращает массив с результатом
     *
     * @return array
     */
    public function getResult(): array
    {
        return [

            ['Переплата кредита в месяц'        => $this->costMonth],
            ['Переплата по процентам, рублей:'  => $this->getInterestOverpayment()], 
            ['Стоимость кредита в год:'         => $this->getTotalCost()],
            ['Процент:'                         => $this->annualInterestRate], 

            ['Долг клиента за ' . $this->period . ' месяцев'    => $this->costForPeriodClient],
            ['Долг продавца за ' . $this->period . ' месяцев'   => $this->costForPeriodSeller],

            ['Взнос клиента в месяц'  => $this->monthlyClientPayment],
            ['Взнос продавца в месяц' =>  $this->monthlySellerPayment]
 
        ];
    }

}