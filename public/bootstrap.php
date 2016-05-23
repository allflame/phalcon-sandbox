<?php
require __DIR__ . '/../vendor/autoload.php';
$applicationDir = __DIR__ . '/..';
$cacheDir = 'cache';
$configDir = 'config';
$diConfig = $configDir . DIRECTORY_SEPARATOR . 'di.yml';
$cacheFile = $cacheDir . DIRECTORY_SEPARATOR . 'container/container.php';

$di = (new \Vain\Phalcon\Di\Symfony\Factory\SymfonyDiFactory($applicationDir, $diConfig, $cacheFile))->createDi();