<?php

namespace App\RequestValidators;

use App\Requests\CreditRequest;

class CreditRequestValidators
{
    protected $creditRequest;

    protected $errors = [];
 
    public function __construct(CreditRequest $creditRequest) 
    {
        $this->creditRequest = $creditRequest;
    }

    /**
     * Проверка 
     *
     * @return void
     */
    public function validation(): void
    {
        foreach ($this->rules() as $key => $rule) {
            try {
                if (! is_callable($rule)) {
                    throw new \RuntimeException('Правило валидации должно быть вызываемой');
                }
                $rule($this->creditRequest->getAttribute($key));

            } catch (\InvalidArgumentException $error) {
                $this->addError($error->getMessage());
            }
        }
    }

    /**
     * Добавляет ошибку в список
     *
     * @param string $error
     * @return void
     */
    protected function addError(string $error): void 
    {
        $this->errors[] = $error;
    }

    protected function rules(): array
    {
        return [
            CreditRequest::ATTRIBUTE_TOTAL_AMOUNT => function ($value, $data = []): void { 
                $value = intval($value);

                if ($value <= 0) {
                    throw new \InvalidArgumentException('Значение суммы кредитования должно быть больше 0');
                }

                if (! is_int($value)) {
                    throw new \InvalidArgumentException('Значение суммы кредитования должно числом');
                }

                if ($value > 10000000) {
                    throw new \InvalidArgumentException('Значение суммы кредитования слишком большое, превышает 10 000 000');
                }
            },
            CreditRequest::ATTRIBUTE_PERIOD => function ($value, $data = []): void { 
                $value = intval($value);

                if ($value < 0) {
                    throw new \InvalidArgumentException('Значение периода должно быть больше 1');
                }

                if (! is_int($value)) {
                    throw new \InvalidArgumentException('Значение периода должно быть числом');
                }

                if ($value > 36) {
                    throw new \InvalidArgumentException('Значение периода кредитования слишком большое, превышает 36 мес.');
                }
            },
            CreditRequest::ATTRIBUTE_INITIAL_FEE => function ($value, $data = []): void { 
                $value = intval($value);

                if ($value < 0) {
                    throw new \InvalidArgumentException('Первоначальный взнос должен быть больше 1');
                }

                if (! is_int($value)) {
                    throw new \InvalidArgumentException('Первоначальный взнос должен быть числом');
                }
            },
        ];
    }

    /**
     * Проверяет на ошибки
     *
     * @return boolean
     */
    public function hasErrors(): bool
    {
        return ! empty($this->errors);
        // return (bool) count($errors); // Почему-то не работает =(
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
        
        return $this->errors;
    }
}