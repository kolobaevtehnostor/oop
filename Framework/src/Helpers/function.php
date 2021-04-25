<?php

use Framework\Container;

function dump($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
 }

function app(string $key)
{
    $container = Container::getInstance();
    
    return $container->get($key);
}

/**
 *
 * @param string $key
 * @param [type] $object
 * @return void
 */
function bind(string $key, $object)
{
    $container = Container::getInstance();
    
    return $container->bind($key, $object);
}