<?php
namespace App\Controllers;

use Framework\Http\Controllers\Base\BaseController;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\Base\BaseView;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Components\Calculator\CalculatorComponent;
use App\Components\Calculator\Writer\ResultContainerWriterAll;

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

        $writer = ResultContainerWriterAll::class;
        
        $calculator = new CalculatorComponent($writer);
        
        $calculator->calculate($this->form);

        return $this->json($writer::all());
    }

    protected function calculate(): array
    {

        return $calculator->calculate(
            $this->form
        );
    }
}