<?php
try {

    require '../public/bootstrap.php';

    $request = $di->get('app.command.testBuilder')->execute();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}