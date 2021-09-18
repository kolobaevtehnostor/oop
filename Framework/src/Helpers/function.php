<?php

use Framework\Container;
use Framework\Config\Configuration;

function dump($value) {
    echo '<pre>';
    print_r($value);
    echo '</pre>';
 }

function dd($value) {
   dump($value);
   die;
 }

function app(string $key) {
    $container = Container::getInstance();
    
    return $container->get($key);
}

/**
 * Возвращает свойство конфигурации
 *
 * @param string $key
 * @return mixed
 */
function getConfig(string $key) {
    $config = app(Configuration::class);
    
    return $config->getParam($key);
}

/**
 * Возвращает свойство конфигурации
 *
 * @param string $key
 * @return mixed
 */
function setConfigParamDir(string $value) {
    
    $config = app(Configuration::class);
    
    $config->setParamDir($value);
}

/**
 *
 * @param string $key
 * @param mixed $object
 * @return void
 */
function bind(string $key, $object) {
    $container = Container::getInstance();
    
    $container->bind($key, $object);
}


/**
 * Возвращает число в формате денег
 *
 * @param int $number
 * @param string $currency
 * @return string
 */
function printCurrencyRub(string $number, string $currency = ' Руб.'): string {

    return number_format($number, 2, ',', ' ') . $currency;
}