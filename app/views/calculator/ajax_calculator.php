<?php
/*
header('Content-Type: application/json');

if (! isset($calc)) {
    
    //echo json_encode([ 0 => ['name' => 'Ошибка', 'value' => 'Расчет не возможен']], JSON_UNESCAPED_UNICODE);
    //die();
}

$res = $calc->getTotalResult();

echo $res->printResultJson();