<?php

namespace Framework\Models\Builder\PDO;

class Command
{
    private $sql;
    private $bindings;

    public function __construct(string $sql, array $bindings) 
    {
        $this->sql = $sql;
        $this->bindings = $bindings;
    }

    /**
     * Возвращает запрос
     *
     * @return string
     */
    public function getSql(): string
    {
        return $this->sql;
    }

    /**
     * Возвращает элементы запроса
     *
     * @return array
     */
    public function getBindings(): array
    {
        return $this->bindings;
    }
}