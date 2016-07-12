<?php
try {

    require '../public/bootstrap.php';

    $request = $di->get('app.command.testTime')->execute();
} catch (\Exception $e) {
    echo "Exception: ", $e->getMessage();
}