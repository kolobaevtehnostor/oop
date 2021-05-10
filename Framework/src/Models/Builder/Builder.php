<?php

namespace Framework\Models\Builder;

class Builder
{
    /**
     * Общие данные
     * @var array
     */
    protected $data = [];

    /**
     * Выборка 
     * @var array
     */
    protected $result = [];

    /**
     * @var self
     */
    protected static $instance;

    public function __construct(array $data) 
    {
        $this->data = $data;
    }

    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
    public function findAll()
    {
        return $this->result;
    }

    /**
     * Возвращает аттрибут
     *
     * @param string $name
     * @return mixed
     */
    public function findOne()
    {
        return current($this->result);
    }

    /**
     * Делает выборку
     *
     * @param string $key
     * @param string $value
     * @param string $data
     * @return void
     */
    public function where(string $key, string $operator, string $value)
    {
        foreach ($this->data as $idKey => $row) {

            if ($this->switchOperator($row[$key], $operator,  $value)) {

                $this->result[$idKey] = $this->data[$idKey];
            }
        }
        
    }

    /**
     * выбирает действие оператора
     *
     * @param string $expr
     * @param string $operator
     * @param string $value
     * @return bool
     */
    protected function switchOperator(string $expr, string $operator, string $value): bool
    {
        switch ($operator) {
            case '>':
                return $expr > $value;
            case '<':
                return $expr < $value;
            case '=':
                return $expr == $value;
            case '>=':
                return $expr >= $value;
            case '<=':
                return $expr <= $value;
            default:
                throw new \RuntimeException('Оператор не существует');
        }
    } 

    /**
     * Возвращает результат 
     *
     * @return array
     */
    public function getResult(): array
    {
        return $this->result;
    }
}