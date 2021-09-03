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
        
        $cmd->execute($contect);

        dd($contect->getParam('writer', '')::all());
//        $cmd->attach(new LoggableObserver());

//        $cmd->execute($contect);

//        $cmd->notify();

        /*
                1 Сделать логирование результатов и запросов на расчет калькулятора
                $log->channel('logs/calculation_results')->write($fileName, $logData);
                2 Добавить логирование ошибок приложения
         */

    /*
        $log = new Log();
        $log->write($data);

        $xml = new..
        $xml->gen($log);

        $sendManager = new Log();
        $sendManager->send($data, $url);
    */
        $result = $contect->getParam('result', '');

        return $this->json($result);

        //return $this->json($writer::all());
    }
}
