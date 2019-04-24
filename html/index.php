<?php
session_start();
require_once '../app/composer/vendor/autoload.php';
require_once '../app/config.php';
require_once '../app/config2.php';

/*
$log = new Monolog\Logger("teste");
$log->pushHandler(new Monolog\Handler\StreamHandler("logs/erros.log", Monolog\Logger::WARNING));
$log->addError("Errado!");
*/

$core = new Core\Core();
$core->run();