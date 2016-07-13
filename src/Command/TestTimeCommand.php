<?php
/**
 * Vain Framework
 *
 * PHP Version 7
 *
 * @package   phalcon-sandbox
 * @license   https://opensource.org/licenses/MIT MIT License
 * @link      https://github.com/allflame/phalcon-sandbox
 */
namespace App\Command;

use Vain\Time\Factory\TimeFactoryInterface;
use Vain\Time\Zone\TimeZone;

/**
 * Class TestTimeCommand
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TestTimeCommand
{
    private $timeFactory;

    /**
     * TestTimeCommand constructor.
     *
     * @param TimeFactoryInterface $timeFactory
     */
    public function __construct(TimeFactoryInterface $timeFactory)
    {
        $this->timeFactory = $timeFactory;
    }

    /**
     * @return string
     */
    public function execute()
    {
        $time3 = $this->timeFactory->createFromString('now', 'America/Denver');
        $time4 = $time3->setTimezone(new TimeZone('Europe/Kiev', 'Europe/Kiev', 'EET'));
        echo $time3->format(DATE_W3C) . "\n";
        echo $time4->format(DATE_W3C);
    }
}