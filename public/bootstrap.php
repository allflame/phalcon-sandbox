<?php
require __DIR__ . '/../vendor/autoload.php';
$applicationDir = __DIR__ . '/..';
$diConfig = 'config/di.yml';
$cacheFile = 'cache/container/container.php';

$di = (new \Vain\Phalcon\Di\Symfony\Factory\SymfonyDiFactory($applicationDir, $diConfig, $cacheFile))->createDi();
$application = $di->get('app.self');
$di->get('app.bootstrapper.factory')->createBootstrapper()->bootstrap($application);
$emitter = new \Vain\Http\Response\Emitter\Sapi\SapiEmitter();