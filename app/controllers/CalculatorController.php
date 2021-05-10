<?php
namespace App\Controllers;

use Framework\Http\Controllers\Base\BaseController;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\Base\BaseView;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Models\GridLoan;
use App\Models\GridInstallment;
use App\Components\Calculator\CalculatorComponent;
use App\Models\Base\BaseModel;

class CalculatorController extends BaseController
{
    protected $form;

    /**
     * Возвращает страницу
     *
     * @return string
     */
    public function actionShow($request): BaseView 
    {
        return $this->render('calculator/index', [
            'title' => 'Два калькулятора',
            'pageTitle' => 'Два калькулятора!!!'
        ]);
    }

    /**
     * Возвращает страницу ответа
     *
     * @return string|JsonResponse
     */
    public function actionCalculate($request): JsonResponse
    {

        $this->form = app(CreditRequest::class);

        $validator = new CreditRequestValidators($this->form);

        $validator->validate();

        if ($validator->hasErrors()) {

            return $this->json(
                    $validator->getErrors()
                );
        }

        return $this->json(
            $this->calculate()
        );

    }

    protected function calculate(): array
    {
        $totalAmountForCalculate     = $this->form->getAttribute('totalAmount');
        $monthsForCalculate          = $this->form->getAttribute('period');
        $downPaymentForCalculate     = $this->form->getAttribute('downPayment');
        $typeCalculator              = $this->form->getAttribute('typeCalculator');
        $percentForCalculate         = $downPaymentForCalculate / $totalAmountForCalculate * 100;

        $calcModel = GridLoan::byGreaterOrEqualMonths($monthsForCalculate)
            ->byGreaterOrEqualPercent($percentForCalculate)
            ->findOne();

        return CalculatorComponent::calculate(
            $typeCalculator,
            $totalAmountForCalculate,
            $monthsForCalculate,
            $downPaymentForCalculate,
            $calcModel['annual_rate']
        );
    }
}