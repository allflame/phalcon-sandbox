<?php
/**
 * Created by PhpStorm.
 * User: allflame
 * Date: 6/9/16
 * Time: 10:17 AM
 */

namespace App\Command;

use Vain\Comparator\Expression\Equal\EqualExpression;
use Vain\Comparator\Expression\GreaterOrEqual\GreaterOrEqualExpression;
use Vain\Comparator\Expression\LessOrEqual\LessOrEqualExpression;
use Vain\Comparator\Repository\ComparatorRepositoryInterface;
use Vain\Core\Runtime\RuntimeData;
use Vain\Expression\Builder\ExpressionBuilder;
use Vain\Rule\Rule;

class TestRuleCommand
{

    private $builder;

    private $comparatorRepository;

    /**
     * TestRuleCommand constructor.
     * @param ExpressionBuilder $expressionBuilder
     * @param ComparatorRepositoryInterface $comparatorRepository
     */
    public function __construct(ExpressionBuilder $expressionBuilder, ComparatorRepositoryInterface $comparatorRepository)
    {
        $this->builder = $expressionBuilder;
        $this->comparatorRepository = $comparatorRepository;
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
                ->getExpression(),
            $this->comparatorRepository->getComparator('int')
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
                ->getExpression(),
            $this->comparatorRepository->getComparator('int')
        );
        $basketRule = new Rule('basket', $basketExpression);
        $phpVersionExpression = new LessOrEqualExpression(
            $this->builder
                ->context()
                ->property('php_version')
                ->getExpression(),
            $this->builder
                ->mode('string')
                ->inPlace('7')
                ->getExpression(),
            $this->comparatorRepository->getComparator('string')
        );
        $phpRule = new Rule('php', $phpVersionExpression);
        $andExpression = $this->builder->andX($basketRule, $phpRule);
        $promo = new Rule('promo', $andExpression);

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

        return $promo->__toString() . "\n" . $promo->interpret($runtimeData)->__toString();
        //return $result->__toString();
        //return $result->accept($this->parser);
        //var_dump($specialRule->accept($this->interpreter->withContext($runtimeData)));
        //die();
        //return $specialRule->accept($this->parser); // . "\n" . $andExpression->accept($this->evaluator->withContext($runtimeData));
    }
}