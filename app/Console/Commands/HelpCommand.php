<?php

namespace App\Console\Commands;

use Framework\Console\Commands\Base\Command;

class HelpCommand implements Command
{
    /**
     * @var string
     */
    protected $message = '';

    public function handle(array $arg = []): void
    {
        
        $this->message = 
            "\n\033[33m Команды \033[0m  \033[33m                          Описание \033[0m \n\n" . 
            "\033[32m help \033[0m                               Выводит список команд \n" . 
            "\033[32m calculate  -l -totalA=100000 -per=6 -downPay=0 \033[0m                  Калькулятор кредитования \n" .
            "\033[32m calculate  -i -totalA=100000 -per=6 -downPay=0 \033[0m                  Калькулятор рассрочки \n" ;
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
}
