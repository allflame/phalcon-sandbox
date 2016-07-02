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

/**
 * Class IndexController
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class IndexController extends Controller
{
    public function testRuleAction()
    {
        /**
         * @var TestRuleCommand $command
         */
        $command = $this->getDI()->get('app.command.testRule');
        $this->response->appendContent($command->execute());
    }

    public function testBuilderAction()
    {
        /**
         * @var TestRuleCommand $command
         */
        $command = $this->getDI()->get('app.command.testBuilder');
        $this->response->appendContent($command->execute());
    }
}