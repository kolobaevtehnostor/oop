<?php

namespace Framework\Models\Builder\PDO;

use Framework\Config\DatabaseConnect;
use Framework\Models\Builder\PDO\Command;

class Builder
{
    protected $query = '';
    protected $select = '*';
    protected $from = '';
    protected $where = '';
    protected $whereData = [];

    public function __construct(string $tableName) 
    {
        $this->from = $tableName;
    }

    /**
     * Формируем безопасный where
     *
     * @param string $key
     * @param string $operator
     * @param string $value
     * @return void
     */
    public function where(string $key, string $operator, string $value): void
    {
        $whereStart = $this->where == '' ? '' : ' AND ';

        $this->where .= $whereStart .' `'. $key . '` ' . $operator . ' :' . $key;
        $this->whereData[$key] = $value;
    }

    /**
     * Формирует запрос
     *
     * @return void
     */
    private function makeSql(): void
    {
        $this->query = 'SELECT ' . $this->select ?: '*';
        $this->query .= ' FROM ' . $this->from;
        $this->query .= ' WHERE ' . $this->where;
    }

    /**
     * Возвращает запрос SQL
     *
     * @return string
     */
    public function getSafeSql(): Command
    {
        $this->makeSql();

        return new Command(
            $this->query,
            $this->whereData
        );
    }
}