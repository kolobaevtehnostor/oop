<?php

namespace Framework\Console\Commands\Base;

use Framework\Console\ConsoleInputHandler;

interface Command
{
    public function handle(ConsoleInputHandler $arg): void;
    public function getMessage(): string;
}