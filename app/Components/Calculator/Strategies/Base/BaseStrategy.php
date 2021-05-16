<?php 

namespace App\Components\Calculator\Strategies\Base;

use Framework\Models\Base\BaseModel;
use App\Components\Calculator\Strategies\Base\StrategyInterface;

abstract class BaseStrategy implements StrategyInterface
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