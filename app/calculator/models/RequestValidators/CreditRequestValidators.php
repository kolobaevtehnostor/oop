<?php

namespace App\Calculator\Models\RequestValidators;

use App\Calculator\Requests\CreditRequest;

class CreditRequestValidators
{
    protected $creditRequest;

    protected $errors = [];
 
    public function __construct(CreditRequest $creditRequest) 
    {
        $this->creditRequest = $creditRequest;
        $this->rules = $rules;
    }

    public function validation(): void
    {
        foreach ($this->rules() as $key => $rule) {
            try {
                if (! is_callable( $rule)) {
                    throw new \RuntimeException('Правило валидации должно быть вызываемой');
                }

                $rule($this->creditRequest->getAttribute($key));

            } catch (\InvalidArgumentException $error) {

                $this->addError($error->getMessage());
            }
        }
    }

    protected function addError(string $error): void 
    {
        $this->errors[] = $error;
    }

    protected function rules(): array
    {
        return [
            'totalAmount' => function ($value): void { 
                if ($value <= 0) {
                    throw new \InvalidArgumentException('Значение суммы кредитования должно быть больше ноля');
                }

                if (! is_int($value)) {
                    throw new \InvalidArgumentException('Значение суммы кредитования должно числом');
                }
                
                // Дописать правила
            },
        ];
    }

    public function hasErrors(): bool
    {
        return (bool) count($errors);
    }
    
    public function hasNotErrors(): bool 
    {
        return ! $this->hasErrors();
    }
    
    public function getErrors(): array
    {
        if ($this->hasNotErrors()) {
            return [];
        }
        
        $this->errors;
    }
}