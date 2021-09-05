<?php 

namespace App\Components\Calculator\Handlers;

use Framework\Command\Base\BaseCommand;
use Framework\Command\CommandContext;
use App\Components\Calculator\CalculatorComponent;

class CalculatorHandler extends BaseCommand implements \SplSubject
{

    /**
     * @var \SplObjectStorage
     */
    private $observers;

    public function __construct()
    {
        $this->observers = new \SplObjectStorage();
    }

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

    
    /**
     * Методы управления подпиской.
     */
    public function attach(\SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(\SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    /**
     * Запуск обновления в каждом подписчике.
     */
    public function notify(): void
    {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

}