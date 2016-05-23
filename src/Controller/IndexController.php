<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 5/16/16
 * Time: 10:40 AM
 */

namespace App\Controller;

use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        $this->response->appendContent('Test');
    }
}