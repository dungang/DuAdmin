<?php
namespace app\mmadmin\db;

use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionInterface;
use yii\db\conditions\LikeCondition;
use yii\db\conditions\AndCondition;
use yii\db\ExpressionBuilderTrait;

class FullSearchConditionBuilder implements ExpressionBuilderInterface
{
    // Contains constructor and `queryBuilder` property.
    use ExpressionBuilderTrait;
    
    public function build(ExpressionInterface $expression, array &$params = [])
    {
        $columns = $expression->getColumns();
        $value = $expression->getValue();
        
        if($value && $columns && count($columns)>0) {
            $conditions = [];
            foreach ($columns as $column) {
                $conditions[] = new LikeCondition($column, 'OR LIKE', $value);
            }
            return $this->queryBuilder->buildCondition(new AndCondition($conditions), $params);
        }
        return null;
    }
}

