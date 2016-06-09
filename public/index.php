<?php

require 'bootstrap.php';

try {
    $request = $di->get('http.request.factory')->createRequest($_SERVER, $_GET, [], $_POST, $_FILES, $_COOKIE, 'php://input');
    $emitter->send($application->handleRequest($request));
} catch (\Exception $e) {
     echo "Exception: ", $e->getMessage();
}