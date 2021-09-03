<?php 

namespace App\Components\Calculator\Handlers;

use Framework\Command\Base\BaseCommand;
use Framework\Command\CommandContext;
use App\Components\Calculator\CalculatorComponent;

class CalculatorHandler extends BaseCommand 
{
    private function handle(): void
    {
        $writer = $this->context->getParam('writer', '');
        $form = $this->context->getParam('form', []);

        $calculator = new CalculatorComponent($writer);
        
        $calculator->calculate($form);

        
        $this->context->setParam('result', $writer::all());
    }
    
    public function execute(CommandContext $context): void
    {
        $this->context = $context;
        
        $this->handle();
    }
}