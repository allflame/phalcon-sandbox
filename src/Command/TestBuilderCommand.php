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

use Vain\Expression\Parser\ParserInterface;

/**
 * Class TestBuilderCommand
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TestBuilderCommand
{
    private $parser;

    /**
     * TestRuleCommand constructor.
     * @param ParserInterface $parser
     */
    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return string
     */
    public function execute()
    {
        $string = '(3 + 4) * 5';
        $expression = $this->parser->parse($string);

        var_dump($expression);

        return '';
    }
}