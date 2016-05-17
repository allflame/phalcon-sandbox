<?php

require __DIR__ . '/../vendor/autoload.php';

try {

    $bootstrapper = (new \Vain\Phalcon\Bootstrapper\Factory\MvcBootstrapperFactory())->createBootstrapper();
    $application = new \Phalcon\Mvc\Application();
    $bootstrapper->bootstrap($application, new \Phalcon\Di\FactoryDefault());

    echo $application->handle()->getContent();
} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}