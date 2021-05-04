<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class GridLoan extends BaseModel
{
    /**
     * Общая сумма
     * @var int
     */
    protected $amount;

    /**
     * Месяцы
     * @var array
     */
    protected $period;

    /**
     * Первоначальный взнос
     * @var int
     */
    protected $downPayment;

    /**
     * Процентов за три месяца
     * @var float
     */
    protected $percentThreeMonths;

    public function __construct() 
    {
        $this->builder = $this->getJsonToArray();
    }

    /**
     * Возвращает json из файла
     * в виде массива php
     *
     * @param string $nameFile
     * @param string $pathFile
     * @return void
     */
    protected function getJsonToArray(
        string $nameFile = 'loan',
        string $pathFile = ROOT_PATH . '/app/components/calculator/'): array
    {
        $date = file_get_contents($pathFile . $nameFile . '.json' );
        return (array) json_decode($date, true);
    }
    
    /**
     * Возвращает по период месяцы
     *
     * @param self $query
     * @param string $months
     * @return self
     */
    public function scopeByMonths(self $query, string $months): self
    {
        return $query->where('months', '==' , $months);
    }
    
    /**
     * Возвращает по период месяцы
     *
     * @param self $query
     * @param string $months
     * @return self
     */
    public function scopeByGreaterOrEqualMonths(self $query, string $months): self
    {
        return $query->where('months', '>=' , $months);
    }

    /**
     * Возвращает по процентам
     *
     * @param self $query
     * @param string $percent
     * @return self
     */
    public function scopeByGreaterOrEqualPercent(self $query, string $percent): self
    {
        return $query->where('percent', '>=' , $percent);
    }
    
    /**
     * Возвращает по проценты
     *
     * @param self $query
     * @param string $percent
     * @return self
     */
    public function scopeByPercent(self $query, string $percent): self
    {
        return $query->where('percent', '==', $percent);
    }

}