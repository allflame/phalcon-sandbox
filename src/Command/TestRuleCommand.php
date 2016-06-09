<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 6/9/16
 * Time: 10:17 AM
 */

namespace App\Command;

use App\Data\Module\Factory\ModuleFactory;
use Vain\Core\Runtime\RuntimeData;
use Vain\Expression\Boolean\AndX\AndExpression;
use Vain\Expression\Boolean\Equal\EqualExpression;
use Vain\Expression\Boolean\GreaterOrEqual\GreaterOrEqualExpression;
use Vain\Expression\Builder\ExpressionBuilder;
use Vain\Expression\Parser\ParserInterface;
use Vain\Expression\Serializer\SerializerInterface;
use Vain\Rule\Evaluator\EvaluatorInterface;

class TestRuleCommand
{
    private $evaluator;

    private $parser;

    private $serializer;

    private $builder;

    /**
     * TestRuleCommand constructor.
     * @param EvaluatorInterface $evaluator
     * @param ParserInterface $parser
     * @param SerializerInterface $serializer
     * @param ExpressionBuilder $expressionBuilder
     */
    public function __construct(EvaluatorInterface $evaluator, ParserInterface $parser, SerializerInterface $serializer, ExpressionBuilder $expressionBuilder)
    {
        $this->evaluator = $evaluator;
        $this->parser = $parser;
        $this->serializer = $serializer;
        $this->builder = $expressionBuilder;
    }

    /**
     * @return string
     */
    public function execute()
    {
        $filterExpression = new EqualExpression(
            $this->builder
                ->context()
                ->property('type')
                ->getExpression(),
            $this->builder
                ->mode('int')
                ->inPlace(1)
                ->getExpression()
        );
        $expression = new GreaterOrEqualExpression(
            $this->builder
                ->context()
                ->property('basket')
                ->property('transaction')
                ->property('items')
                ->filter($filterExpression)
                ->func('count')
                ->getExpression(),
            $this->builder
                ->mode('int')
                ->inPlace(4)
                ->getExpression()
        );
        $items = [];
        $totalWeight = 0;
        for ($i = 1; $i <= 5; $i++) {
            $weight = $i * 2;
            $items[] = new RuntimeData(['id' => $i, 'type' => $i % 2, 'weight' => $weight]);
            $totalWeight += $weight;
        }
        $transaction = new RuntimeData(['id' => 100, 'items' => $items, 'weight' => $totalWeight]);
        $basket = new RuntimeData(['transaction' => $transaction]);
        $runtimeData = new RuntimeData(['basket' => $basket, 'api' => 'backoffice', 'php_version' => PHP_VERSION]);

        return $expression->accept($this->parser) . "\n" . $expression->accept($this->evaluator->withContext($runtimeData));
    }
}