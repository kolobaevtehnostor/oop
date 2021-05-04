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
        $creditRequest = app(CreditRequest::class);

        $creditRequestValidators = new CreditRequestValidators($creditRequest);

        $creditRequestValidators->validation();

        if ($creditRequestValidators->hasErrors()) {
            $errors = [];
            foreach ($creditRequestValidators->getErrors() as $key => $error) {

                $errors = [ $key => ['name' => 'Ошибка: ', 'value' => $error]];
            }
            
            return $this->json($errors);
        }

        if ( $creditRequest->getAttribute('typeCalculator') == 'loan') {
            
            $calcResult = $this->calculateLoan($creditRequest);
            return $this->json($calcResult);
        }

        $calcResult = $this->calculateInstallment($creditRequest);
        return $this->json($calcResult);
    }

    /**
     * Возвращает результат 
     * расчета кредитного калькулятора
     *
     * @param CreditRequest $creditRequest
     * @return array
     */
    protected function calculateLoan(CreditRequest $creditRequest): array
    {
        $totalAmountForCalculate     = $creditRequest->getAttribute('totalAmount');
        $monthsForCalculate          = $creditRequest->getAttribute('period');
        $downPaymentForCalculate     = $creditRequest->getAttribute('downPayment');
        $percentForCalculate         = $downPaymentForCalculate / $totalAmountForCalculate * 100;

        $calcModel = GridLoan::byGreaterOrEqualMonths($monthsForCalculate)
            ->byGreaterOrEqualPercent($percentForCalculate)
            ->findOneToArray();

        $calcLoan = CalculatorComponent::calculateLoan(
            $totalAmountForCalculate,
            $monthsForCalculate,
            $downPaymentForCalculate,
            $calcModel['annual_rate']
        );

        return $calcLoan->getResult();
    }

     /**
     * Возвращает результат 
     * расчета калькулятора рассрочки
     *
     * @param CreditRequest $creditRequest
     * @return array
     */
    protected function calculateInstallment(CreditRequest $creditRequest): array
    {
        $totalAmountForCalculate     = $creditRequest->getAttribute('totalAmount');
        $monthsForCalculate          = $creditRequest->getAttribute('period');
        $downPaymentForCalculate     = $creditRequest->getAttribute('downPayment');
        $typeCalculatorForCalculate  = $creditRequest->getAttribute('typeCalculator');
        $percentForCalculate         = $downPaymentForCalculate / $totalAmountForCalculate * 100;

        $calcModel = GridInstallment::byGreaterOrEqualMonths($monthsForCalculate)
           ->byGreaterOrEqualPercent($percentForCalculate)
           ->findOneToArray();

        $calcInstallment = CalculatorComponent::calculateInstallment(
            $totalAmountForCalculate,
            $monthsForCalculate,
            $downPaymentForCalculate,
            $calcModel['annual_rate']
        );

        return $calcInstallment->getResult();
    }
    
}