<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 4/5/16
 * Time: 12:47 PM
 */

namespace App\Data\Module\Factory;

use Vain\Data\Exception\UnknownModuleException;
use Vain\Data\Module\Factory\ModuleFactoryInterface;
use Vain\Data\Module\System\RuntimeDataModule;
use Vain\Data\Module\System\TimeDataModule;

class ModuleFactory implements ModuleFactoryInterface
{
    /**
     * @inheritDoc
     */
    public function createModule($moduleName)
    {
        switch ($moduleName) {
            case 'system.time' :
                return new TimeDataModule();
                break;
            case 'system.runtime' :
                return new RuntimeDataModule();
                break;
            default:
                throw new UnknownModuleException($this, $moduleName);
                break;
        }
    }

    public static function test($a, $b)
    {
        return count($a) * $b;
    }
}