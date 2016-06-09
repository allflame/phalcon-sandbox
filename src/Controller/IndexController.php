<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 5/16/16
 * Time: 10:40 AM
 */

namespace App\Controller;

use App\Command\TestRuleCommand;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{
    public function indexAction()
    {
        /**
         * @var TestRuleCommand $command
         */
        $command = $this->getDI()->get('app.command.testRule');
        $this->response->appendContent($command->execute());
    }
}