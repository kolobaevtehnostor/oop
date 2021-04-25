<?php

use Framework\Container;

function dump($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
 }

 function app(string $key)//: object
{
    $container = Container::getInstance();
    
    return $container->get($key);
}