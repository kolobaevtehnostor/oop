<?php

namespace App\Models;

use Framework\Models\Base\BaseModelDTO;

class GridInstallmentDTO extends BaseModelDTO
{
    protected $attributes = [
        'id',
        'months',
        'percent',
        'annual_rate',
        'created_at',
        'updated_at',
    ];
}