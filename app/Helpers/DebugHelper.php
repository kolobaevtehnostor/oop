<?php

namespace App\Helpers;

class DebugHelper 
{
    public function debugPrint($value){
        echo '<pre>';
        print_r($value);
        echo '</pre>';
    }
}