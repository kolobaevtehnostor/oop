<?php 

namespace App\Components\Calculator;
use App\Components\Calculator\Strategies\Base\StrategyInterface;
use App\Components\Calculator\Strategies\CalculateStrategyLoan;
use App\Components\Calculator\Strategies\CalculateStrategyInstallment;
use App\Requests\CreditRequest;
use Framework\Models\Base\BaseModel;
use Framework\Exceptions\BadRequestException;

class CalculatorComponent
{
    /**
     * @var array 
     */
    private $strategies = [
        'installment' => CalculateStrategyInstallment::class,
        'loan'        => CalculateStrategyLoan::class
    ];

    /**
     * @var array
     */
    protected $attributes = [
        'typeCalculator' => '',
        'totalAmount' => 0,
        'period' => 0,
        'downPayment' => 0,
        'costForPeriodClient' => 0,
        'monthlyClientPayment' => 0,
    ];

    /**
     * @var StrategyInterface
     */
    protected $strategy;

    public function __construct(string $resultContainer)
    {
        $this->initResultContainer($resultContainer);
    }

    /**
     * Инициализация resultContainer
     *
     * @param string $resultContainer
     * @return void
     */
    protected function initResultContainer(string $resultContainer): void
    {
        if ($resultContainer instanceof ResultContainerInterface) {
            throw new \InvalidArgumentException('Тип расчета должен отвечать интерфейсу ' . ResultContainerInterface::class);
        }

        $this->resultContainer = new $resultContainer;
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
     * @return float
     */
    protected function percentForCalculate(): float
    {
        return $this->attributes['downPayment'] / $this->attributes['totalAmount'] * 100;
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

        return $model::byGreaterOrEqualMonths($this->attributes['period'])
            ->byGreaterOrEqualPercent($percentForCalculate)
            ->findOne();
    }

    /**
     * Устанавливает свойства
     *
     * @param array $attributes
     * @return void
     */
    public function pushAttributes(array $attributes = []): void
    {
        $this->attributes = array_merge($this->attributes, $attributes);
    }
    
    /**
     * Расчет
     * 
     * @param CreditRequest $form
     */
    public function calculate(CreditRequest $form): void
    {
        $this->type = $form->getAttribute('typeCalculator');
        
        $this->initStrategy();

        $this->pushAttributes($form->getData());

        $calcModel = $this->getCalcModel();

        $this->pushAttributes([
            'annualInterestRate' => $calcModel['annual_rate']
        ]);
        
        $this->pushAttributes([
            'costMonth' => $this->getCostMonth()
        ]);
        
        $this->pushAttributes($this->strategy->calculate($this->attributes));
        

        $this->save();
    }

    /**
     * Возвращает стратегию
     *
     * @return void
     */
    protected function initStrategy(): void
    {
        if (! array_key_exists($this->type, $this->strategies)) {
            throw new \InvalidArgumentException('Неверно указан тип калькулятора');
        }

        $strategy = new $this->strategies[$this->type];
        
        if (! $strategy instanceof StrategyInterface) {
            throw new \InvalidArgumentException('Тип расчета должен отвечать интерфейсу ' . StrategyInterface::class);
        }

        $this->strategy = new $this->strategies[$this->type];
    }

    /**
     * Переплата по процентам, рублей
     *
     * @return integer
     */
    public function getInterestOverpayment(): int
    {
        return $this->attributes['totalAmount'] / 100 * $this->attributes['annualInterestRate'];
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
        return $this->amount - $this->attributes['downPayment'] + $this->getInterestOverpayment();
    }


    protected function save(): void
    {
        $this->resultContainer::setData($this->attributes);
    }

}