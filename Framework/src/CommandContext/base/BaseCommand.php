<?php

namespace Framework\CommandContext\Base;

use Framework\CommandContext\Base\CommandContext;

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