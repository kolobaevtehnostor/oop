<?php
error_reporting(E_ALL);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Calculator\Web;
use App\Calculator\Requests\UrlRequest;

$urlRequest = new UrlRequest($_GET);

$controller = $urlRequest->getAttribute(UrlRequest::ATTRIBUTE_CONTROLLER);
$action = $urlRequest->getAttribute(UrlRequest::ATTRIBUTE_ACTION);

$appWeb =  Web::getInstance();
$appWeb->startApp($controller, $action);

?>
