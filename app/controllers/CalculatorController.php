<?php
namespace App\Controllers;

use Framework\Http\Controllers\Base\BaseController;
use Framework\Http\Responses\JsonResponse;
use Framework\Views\Base\BaseView;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Components\Calculator\CalculatorComponent;
use App\Components\Calculator\Writer\ResultContainerWriterAll;
use Framework\Command\CommandContext;
use App\Components\Calculator\Handlers\CalculatorHandler;
use App\Components\Calculator\Observers\LoggableObserver;

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
        $contect = new CommandContext();

        $this->form = app(CreditRequest::class);

       // dd( $this->form );
        $validator = new CreditRequestValidators($this->form);

        $validator->validate();

        if ($validator->hasErrors()) {

            return $this->json(
                    $validator->getErrors()
                );
        }

        $writer = ResultContainerWriterAll::class;

        $contect->setParam('writer',  ResultContainerWriterAll::class);

        $contect->setParam('form',  $this->form);

        $cmd = new CalculatorHandler();
        
        $cmd->attach(new LoggableObserver());
        
        $cmd->execute($contect);

        $cmd->notify();

        $result = $contect->getParam('result', '');

        return $this->json($result);
    }
}
