<?php
namespace DuAdmin\Db;

use yii\db\ExpressionBuilderInterface;
use yii\db\ExpressionInterface;
use yii\db\conditions\LikeCondition;
use yii\db\conditions\OrCondition;
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
                $conditions[] = new LikeCondition($column, 'LIKE', $value);
            }
            return $this->queryBuilder->buildCondition(new OrCondition($conditions), $params);
        }
        return null;
    }
}

