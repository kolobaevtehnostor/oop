<?php

namespace Framework\Command\Base;

use Framework\Command\CommandContext;

abstract class BaseCommand
{
    public $context;

    /**
     * Выполнение паттерна команда
     *
     * @param CommandContext $context
     * @return void
     */
    abstract public function execute(CommandContext $context): void;

}