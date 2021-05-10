<?php 

namespace App\Components\Calculator;
use App\Components\Calculator\Strategies\Base\StrategyInterface;
use App\Components\Calculator\Strategies\CalculateStrategyLoan;
use App\Components\Calculator\Strategies\CalculateStrategyInstallment;

class CalculatorComponent
{

    /**
     * @var array 
     */
    private static $strategies = [
        'installment' => CalculateStrategyInstallment::class,
        'loan'        => CalculateStrategyLoan::class
    ];

    /**
     * Сумма, рублей
     * @var int
     */
    public $amount;

    /** Период, мес.
     * @var int
     */
    public $period;
    
    /** Первоначальный взнос, руб.
     * @var int
     */
    public $downPayment;

    /** Стоимость кредита за период месяцев
     * @var int
     */
    public $costForPeriod;

    /** Стоимость кредита за период месяцев (Клиент)
     * @var int
     */
    public $costForPeriodClient;
    
    /** Стоимость кредита за период месяцев (Продавец)
     * @var int
     */
    public $costForPeriodSeller;

    /** Стоимость кредита
     * @var int
     */
    public $monthlyPayment;    
    
    /** Стоимость кредита для клиента в месяц
     * @var int
     */
    public $monthlyClientPayment;

    /** Стоимость кредита для продавца в месяц
     * @var int
     */
    public $monthlySellerPayment;

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    public function __construct(int $amount, int $period, int $downPayment, float $annualInterestRate) 
    {
        $this->amount             = $amount;
        $this->period             = $period;
        $this->downPayment        = $downPayment;
        $this->annualInterestRate = $annualInterestRate;

        $this->costMonth = $this->getCostMonth();
    }

    /**
     * Обычно Контекст позволяет
     * заменить объект Стратегии
     * во время выполнения.
     */
    public function setStrategy(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * Расчет
     * 
     * @param integer $amount
     * @param integer $period
     * @param integer $downPayment
     * @param float $annualInterestRate
     * @return array
     */
    public static function calculate(string $type, int $amount, int $period, int $downPayment, float $annualInterestRate): array
    {
        $calc = new static($amount, $period, $downPayment, $annualInterestRate);

        $strategy = static::getStrategy($type);
        $calc->setStrategy($strategy);

        $calc = $calc->strategy->calculate($calc);

        return $calc->getResult();
    }

    /**
     * Возвращает стратегию
     *
     * @param string $strategiesKey
     * @return StrategyInterface
     */
    protected static function getStrategy(string $strategiesKey): StrategyInterface
    {
        if (! isset(static::$strategies[$strategiesKey])) {
            
            throw new BadRequestException('Неверно указан тип калькулятора');
        }

        $strategy = static::$strategies[$strategiesKey];

        return new $strategy;
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