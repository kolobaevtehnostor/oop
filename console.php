<?php

error_reporting(E_ALL);

ini_set("display_errors", 1);

define('ROOT_PATH', __DIR__ . '/../');

require_once 'vendor/autoload.php';
require_once 'Framework/src/Helpers/function.php';

use Framework\Console\Kernel;

$commandsAlias = [
    'help'      => 'App\Console\Commands\HelpCommand',
    'calculate' => 'App\Console\Commands\CalculateCommand'
];


$options = [];

foreach ($argv as $arg) {
    $option = explode("=", $arg);

    if ('-' == substr($arg, 0, 1)) {
        $options[$option[0]] = true;
    }

    if (isset($option[1])) {
        $options[$option[0]] = $option[1];
    }
}

$command = $commandsAlias['help'];

if (! empty($argv[1]) && array_key_exists( $argv[1], $commandsAlias)) {
    $command = $commandsAlias[$argv[1]];
}

$kernel = new Kernel($command);

echo $kernel->handle($options);

//$response = $kernel->handle($request);

//$response->send();

exit();