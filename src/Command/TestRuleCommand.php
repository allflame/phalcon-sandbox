<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 6/9/16
 * Time: 10:17 AM
 */

namespace App\Command;

use Vain\Core\Runtime\RuntimeData;
use Vain\Expression\Boolean\AndX\AndExpression;
use Vain\Expression\Boolean\Equal\EqualExpression;
use Vain\Expression\Boolean\GreaterOrEqual\GreaterOrEqualExpression;
use Vain\Expression\Builder\ExpressionBuilder;
use Vain\Expression\Parser\ParserInterface;
use Vain\Rule\Evaluator\EvaluatorInterface;
use Vain\Rule\Rule;

class TestRuleCommand
{
    private $evaluator;

    private $parser;

    private $builder;

    /**
     * TestRuleCommand constructor.
     * @param EvaluatorInterface $evaluator
     * @param ParserInterface $parser
     * @param ExpressionBuilder $expressionBuilder
     */
    public function __construct(EvaluatorInterface $evaluator, ParserInterface $parser, ExpressionBuilder $expressionBuilder)
    {
        $this->evaluator = $evaluator;
        $this->parser = $parser;
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
        $basketExpression = new GreaterOrEqualExpression(
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
        $basketRule = new Rule('basket', $basketExpression);
        $phpVersionExpression = new EqualExpression(
            $this->builder
                ->context()
                ->property('php_version')
                ->getExpression(),
            $this->builder
                ->mode('int')
                ->inPlace(PHP_VERSION)
                ->getExpression()
        );
        $phpRule = new Rule('php', $phpVersionExpression);
        $andExpression = new AndExpression($basketRule, $phpRule);
        $specialRule = new Rule('special', $andExpression);

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
        return $specialRule->accept($this->evaluator->withContext($runtimeData))->accept($this->parser);
        var_dump($specialRule->accept($this->evaluator->withContext($runtimeData)));
        die();
        return $specialRule->accept($this->parser); // . "\n" . $andExpression->accept($this->evaluator->withContext($runtimeData));
    }
}