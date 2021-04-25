<?php
namespace App\Controllers;

use Framework\Http\Controllers\Base\BaseController;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\Base\BaseView;
use App\RequestValidators\CreditRequestValidators;
use App\Calculator\Models\LoanCalculator;
use App\Calculator\Models\InstallmentCalculator;
use App\Requests\CreditRequest;

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
        
        if ($creditRequest->getAttribute(CreditRequest::ATTRIBUTE_TYPE) == 'loan' ) {
            $calc = LoanCalculator::getIdentity($creditRequest);
        } else {
            $calc = InstallmentCalculator::getIdentity($creditRequest);
        }

        $patch = ($request->server('DOCUMENT_ROOT'));
        
        $calcResult = $calc->getTotalResult()->printResult();

        return $this->json($calcResult);

    }
    

}