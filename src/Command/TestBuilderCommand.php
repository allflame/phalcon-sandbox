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

use Vain\Expression\Lexer\LexerInterface;
use Vain\Expression\Parser\ParserInterface;

/**
 * Class TestBuilderCommand
 *
 * @author Taras P. Girnyk <taras.p.gyrnik@gmail.com>
 */
class TestBuilderCommand
{
    private $parser;

    private $lexer;

    /**
     * TestRuleCommand constructor.
     *
     * @param ParserInterface $parser
     * @param LexerInterface  $lexer
     */
    public function __construct(ParserInterface $parser, LexerInterface $lexer)
    {
        $this->parser = $parser;
        $this->lexer = $lexer;
    }

    /**
     * @return string
     */
    public function execute()
    {
        $string = '3 + 4 * 2 / ( 1 - 5 ) ** 2 ** 3';
        //$string = 'true && false';
        $start = microtime(true);
        $expression = $this->parser->parse($this->lexer->process($string));
        $end = microtime(true);
        printf('Parsing: %f%s', ($end - $start) * 1000, PHP_EOL);
        var_dump($expression->__toString());
        $start = microtime(true);
        var_dump($expression->interpret());
        $end = microtime(true);
        printf('Interpret: %f%s', ($end - $start) * 1000, PHP_EOL);


        return '';
    }
}