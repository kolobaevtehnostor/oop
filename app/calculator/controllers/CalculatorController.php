<?php

namespace App\Calculator\Controllers;

class CalculatorController
{
    /**
     * Возвращает страницу
     *
     * @return string
     */
    public function Show(): string 
    {
       // return require_once $_SERVER['DOCUMENT_ROOT'] . '//../App//Calculator//Views//Calculator//test1.php';
        return require_once $_SERVER['DOCUMENT_ROOT'] . '//../App//Calculator//Views//Calculator//index.php';
    }

    /**
     * Возвращает страницу ответа
     *
     * @return string
     */
    public function Calculate(): string 
    {
        return require_once ($_SERVER['DOCUMENT_ROOT'] . '//ajax_calculator.php');
    }
    

}