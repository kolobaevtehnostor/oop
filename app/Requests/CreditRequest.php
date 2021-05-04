<?php

namespace App\Requests;

use Framework\Http\Requests\Base\FormRequest;

class CreditRequest extends FormRequest
{
    const ATTRIBUTE_TOTAL_AMOUNT = 'totalAmount';
    const ATTRIBUTE_PERIOD       = 'period';
    const ATTRIBUTE_INITIAL_FEE  = 'downPayment';
    const ATTRIBUTE_TYPE         = 'typeCalculator';

    protected $allowedAttributes = [
        'totalAmount',
        'period',
        'downPayment',
        'typeCalculator',
        'annualInterestRate'
    ];
}