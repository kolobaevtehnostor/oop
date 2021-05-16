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
 * @return void
 */
function getConfig(string $key) {
   $config = app(Configuration::class);
    
    return $config->getParam($key);
}

/**
 *
 * @param string $key
 * @param [type] $object
 * @return void
 */
function bind(string $key, $object) {
    $container = Container::getInstance();
    
    return $container->bind($key, $object);
}