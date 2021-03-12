<?php
namespace App\Calculator\Controllers;

use App\Calculator\Requests\CreditRequest;
use App\Calculator\RequestValidators\CreditRequestValidators;
use App\Calculator\Models\LoanCalculator;
use App\Calculator\Models\InstallmentCalculator;


class CalculatorController
{
    /**
     * Возвращает страницу
     *
     * @return string
     */
    public function Show(): string 
    {
        return require_once $_SERVER['DOCUMENT_ROOT'] . '//../App//Calculator//Views//Calculator//index.php';
    }

    /**
     * Возвращает страницу ответа
     *
     * @return string
     */
    public function Calculate(): string 
    {
        $creditRequest = new CreditRequest($_POST);
        $creditRequestValidators = new CreditRequestValidators($creditRequest);
        $creditRequestValidators->validation();

        if ($creditRequestValidators->hasErrors()) {
            $errors = [];
            foreach ($creditRequestValidators->getErrors() as $key => $error) {

                $errors = [ $key => ['name' => 'Ошибка: ', 'value' => $error]];
            }

            header('Content-Type: application/json');
            echo json_encode($errors, JSON_UNESCAPED_UNICODE);
            die();
        }
        
        if ($creditRequest->getAttribute(CreditRequest::ATTRIBUTE_TYPE) == 'loan' ) {
            $calc = LoanCalculator::getIdentity($creditRequest);
        } else {
            $calc = InstallmentCalculator::getIdentity($creditRequest);
        }

        return require_once $_SERVER['DOCUMENT_ROOT'] . '//../App//Calculator//Views//Calculator//ajax_calculator.php';
    }
    

}