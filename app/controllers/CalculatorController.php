<?php
namespace App\Controllers;

use Framework\Http\Controllers\Base\BaseController;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\Base\BaseView;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Components\Calculator\CalculatorComponent;

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
        return CalculatorComponent::calculate(
            $this->form
        );
    }
}