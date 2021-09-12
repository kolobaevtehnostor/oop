<?php

namespace App\Console\Commands;

use Framework\Console\Commands\Base\Command;
use Framework\Command\CommandContext;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Components\Calculator\Handlers\CalculatorHandler;
use App\Components\Calculator\Observers\LoggableObserver;
use App\Components\Calculator\Writer\ResultContainerWriterAll;

class CalculateCommand implements Command
{
    /**
     * @var string
     */
    protected $message = '';

    public function handle(array $arg = []): void
    {
        $this->calculate();
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }

    private function calculate() {
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

        $contect->setParam('data',  [
            'totalAmount' => 100000,
            'period' => 6,
            'downPayment' => 0,
            'typeCalculator' => 'loan'
        ]);

        $cmd = new CalculatorHandler();
        
        $cmd->attach(new LoggableObserver());
        
        $cmd->execute($contect);

        $cmd->notify();

        $result = $contect->getParam('result', '');

        return $this->json($result);
    }
}
