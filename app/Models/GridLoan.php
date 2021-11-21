<?php

namespace App\Models;

use Framework\Models\Base\BaseModel;

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

    /**
     * @see BaseModel 
     */
    public function getTableName(): string
    {
        return 'calculator_loan';
    }
    
    /**
     * @see BaseModel 
     */
    public function getModelDtoClass(): string
    {
        return 'App\Models\GridInstallmentDTO';
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