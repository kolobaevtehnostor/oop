<?php 

namespace App\Components\Calculator;
use App\Components\Calculator\Strategies\Base\StrategyInterface;
use App\Components\Calculator\Strategies\CalculateStrategyLoan;
use App\Components\Calculator\Strategies\CalculateStrategyInstallment;
use App\Requests\CreditRequest;
use Framework\Models\Base\BaseModel;

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

    /**
     * Тип расчета
     * @var int
     */
    public $type;

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
     * @return float
     */
    protected function percentForCalculate(): float
    {
        return $this->downPayment / $this->amount * 100;
    }
    
    /**
     * Возвращает модель
     *
     * @return BaseModel
     */
    protected function getCalcModel(): array
    {
        $model = $this->strategy->getModel();

        $percentForCalculate = $this->percentForCalculate();

        return $model::byGreaterOrEqualMonths($this->period)
            ->byGreaterOrEqualPercent($percentForCalculate)
            ->findOne();
    }

    /**
     * Устанавливает свойства
     *
     * @param CreditRequest $form
     * @return void
     */
    public function setAttributes(CreditRequest $form): void
    {
        $this->type        = $form->getAttribute('typeCalculator');
        $this->amount      = $form->getAttribute('totalAmount');
        $this->period      = $form->getAttribute('period');
        $this->downPayment = $form->getAttribute('downPayment');

        $calcModel = $this->getCalcModel();

        $this->annualInterestRate = $calcModel['annual_rate'];
        
        $this->costMonth = $this->getCostMonth();
    }
    
    /**
     * Расчет
     * 
     * @param CreditRequest $form
     * @return array
     */
    public static function calculate(CreditRequest $form): array
    {
        
        $type = $form->getAttribute('typeCalculator');
        
        $calc = new static();
        
        $strategy = static::getStrategy($type);

        $calc->setStrategy($strategy);

        $calc->setAttributes($form);

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