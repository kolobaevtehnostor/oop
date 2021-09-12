<?php

namespace Framework\Console\Commands\Base;

interface Command
{
    public function handle(array $arg = []): void;
    public function getMessage(): string;
}