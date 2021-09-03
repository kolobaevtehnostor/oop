<?php

namespace Framework\Command\Base;

use Framework\Command\CommandContext;

abstract class BaseCommand
{
    protected $context;

    /**
     * Выполнение паттерна команда
     *
     * @param CommandContext $context
     * @return void
     */
    abstract public function execute(CommandContext $context): void;

}