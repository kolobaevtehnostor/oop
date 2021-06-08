<?php 

namespace App\Components\Calculator\Strategies\Base;

use Framework\Models\Base\BaseModel;

abstract class BaseStrategy
{
    /**
     * @var BaseModel
     */
    protected $model;

    /**
     * Возвращает модель
     *
     * @return BaseModel
     */
    public function getModel(): BaseModel
    {
        return $this->model;
    }
}