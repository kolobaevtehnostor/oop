<?php

namespace App\Requests;

use App\Core\Requests\Base\FormRequest;

class CreditRequest extends FormRequest
{
    const ATTRIBUTE_TOTAL_AMOUNT = 'totalAmount';
    const ATTRIBUTE_PERIOD = 'period';
    const ATTRIBUTE_INITIAL_FEE = 'initialFee';
    const ATTRIBUTE_TYPE = 'typeCalculator';

    protected $allowedAttributes = [
        'totalAmount',
        'period',
        'initialFee',
        'typeCalculator',
        'annualInterestRate'
    ];
}