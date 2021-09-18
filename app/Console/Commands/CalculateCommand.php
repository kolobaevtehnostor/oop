<?php

namespace App\Console\Commands;

use Framework\Console\Commands\Base\Command;
use Framework\Command\CommandContext;
use App\Requests\CreditRequest;
use App\RequestValidators\CreditRequestValidators;
use App\Components\Calculator\Handlers\CalculatorHandler;
use App\Components\Calculator\Observers\LoggableObserver;
use App\Components\Calculator\Writer\ConsoleResultContainerWriterAll;
use Framework\Console\ConsoleInputHandler;

class CalculateCommand implements Command
{
    /**
     * @var string
     */
    protected $message = '';

    public function handle(ConsoleInputHandler $arg): void
    {
        $this->calculate($arg);
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }

    private function calculate(ConsoleInputHandler $arg) {

        $contect = new CommandContext();

        $this->form = app(CreditRequest::class);
        
        $validator = new CreditRequestValidators($this->form);

        $validator->validate();

        if ($validator->hasErrors()) {
           echo "\033[31m" . implode("\n", $validator->getErrors()) . "\033[0m\n";

           return;
        }

        $writer = ConsoleResultContainerWriterAll::class;

        $contect->setParam('writer',  ConsoleResultContainerWriterAll::class);

        $contect->setParam('form',  $this->form);

        $cmd = new CalculatorHandler();
        
        $cmd->attach(new LoggableObserver());
        
        $cmd->execute($contect);
        
        $cmd->notify();

        $result = $contect->getParam('result', '');

        echo "\033[32m" . implode("\n", $result) . "\033[0m\n";
        
        return;
    }
}
