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
        $london = new \DateTimeZone('America/Phoenix');
        $utc = new \DateTimeZone('UTC');
        $time1 = new \DateTime('now', $london);
        $time2 = clone $time1;
        echo $time1->format('Y-m-d H:i:s T') . "\n";
        echo $time2->setTimezone($utc)->format('Y-m-d H:i:s T') . "\n";
        $time3 = $this->timeFactory->createFromString('now', 'America/Denver');
        $time4 = $this->timeFactory->createFromString('now', 'UTC');
        echo $time3->format(DATE_W3C);
        echo $time3->format('Y-m-d H:i:s T')  . "\n";
        echo $time4->format('Y-m-d H:i:s T')  . "\n";
        echo $time3->getTimeZoneSpec() . "\n";
        echo $time3->toSystem()  . "\n";
        echo $time4->toSystem()  . "\n";
        echo $time3->getTimezone()->getSynonym() . "\n";
        $time5 = $this->timeFactory->createFromString('now', 'Europe/London (BST GMT+0100)');
        echo $time5->toSystem();
    }
}