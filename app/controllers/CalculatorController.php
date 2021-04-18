<?php
namespace App\Controllers;

use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Calculator\Models\LoanCalculator;
use App\Calculator\Models\InstallmentCalculator;
use App\Core\Controllers\Base\BaseController;
use App\Core\Responses\JsonResponse;
use App\Core\Views\View;

class CalculatorController extends BaseController
{
    /**
     * Возвращает страницу
     *
     * @return string
     */
    public function actionShow($request): View 
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
        $creditRequest = CreditRequest::getInstance();

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