<?php

namespace App\Console\Commands;

use Framework\Console\Commands\Base\Command;
use Framework\Console\ConsoleInputHandler;

class MigrateCommand implements Command
{
    /**
     * @var string
     */
    protected $message = '';

    public function handle(ConsoleInputHandler $arg): void
    {
        $this->message = exec('php vendor/bin/phinx migrate');

        echo "\n" . $this->message . "\n";
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
}
