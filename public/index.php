<?php

require 'bootstrap.php';

try {
    $application = $di->get('app.self');
    $di->get('app.bootstrapper.factory')->createBootstrapper()->bootstrap($application);
    $application->handle()->send();
} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}