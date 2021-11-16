<?php

namespace App\Console\Commands;

use Framework\Console\Commands\Base\Command;
use Framework\Console\ConsoleInputHandler;

class MakeMigrateCommand implements Command
{
    /**
     * @var string
     */
    protected $message = '';

    public function handle(ConsoleInputHandler $arg): void
    {

        $this->message = exec('php vendor/bin/phinx create ' . $arg->server('argv')[2] . '\n');

        echo "\n" . $this->message . "\n";
    }
    
    public function getMessage(): string
    {
        return $this->message;
    }
}
