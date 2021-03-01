<?php
header('Content-Type: application/json');

use App\Calculator\Models\LoanCalculator;
use App\Calculator\Models\InstallmentCalculator;

if ( empty ($_POST)) {
    die();
}

if ($_POST['typeCalculator'] == 'loan' ) {
    $calc = LoanCalculator::getIdentity($_POST['amount'], $_POST['period'], $_POST['downPayment']);
} else {
    $calc = InstallmentCalculator::getIdentity($_POST['amount'], $_POST['period'], $_POST['downPayment']);
}

if (! isset($calc)) {
    
    echo json_encode([ 0 =>['name' => 'Ошибка', 'value' => 'Расчет не возможен']], JSON_UNESCAPED_UNICODE);
    die();
}

$res = $calc->getTotalResult();

echo $res->printResultJson();