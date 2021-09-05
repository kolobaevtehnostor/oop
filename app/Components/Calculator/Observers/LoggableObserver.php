<?php 

namespace App\Components\Calculator\Observers;

use Framework\Log;
/**
 * Конкретные Наблюдатели реагируют на обновления, выпущенные Издателем, к
 * которому они прикреплены.
 */
class LoggableObserver implements \SplObserver
{
    /**
     * @var string
     */
    private $message;

    public function update(\SplSubject $subject): void
    {
        foreach ($subject->context->getParam('result') as $key=>$item) {
            $this->message .= $key . ': ' . $item . ' | '; 
        }
        
        Log::info('Результат: ' . $this->message, 'ldjfsdflds');

    }
}