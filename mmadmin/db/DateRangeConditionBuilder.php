<?php

namespace app\mmadmin\db;

use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionInterface;
use yii\db\ExpressionBuilderTrait;
use yii\db\conditions\SimpleCondition;
use yii\db\conditions\AndCondition;
use yii\db\Exception;

class DateRangeConditionBuilder implements ExpressionBuilderInterface
{
    // Contains constructor and `queryBuilder` property.
    use ExpressionBuilderTrait;

    /**
     * {@inheritdoc}
     * @see \yii\db\ExpressionBuilderInterface::build()
     */
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        if ($daterange = $expression->getDaterange()) {
            $dates = explode('~', $daterange);
            $len = count($dates);
            // 只有一个值，不是区间
            if ($len == 1) {
                return $this->queryBuilder->buildCondition(new SimpleCondition($expression->getColumn(), '>=', strtotime($dates[0])), $params);
            } else if ($len == 2) {
                return $this->queryBuilder->buildCondition(new AndCondition([
                    new SimpleCondition($expression->getColumn(), '>=', strtotime($dates[0])),
                    new SimpleCondition($expression->getColumn(), '<=', strtotime($dates[1] . ' 23:59:59'))
                ]), $params);
            } else {
                throw new Exception('Db query expression error!');
            }
        }
    }
}
