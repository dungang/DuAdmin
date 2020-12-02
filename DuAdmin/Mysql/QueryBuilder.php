<?php
namespace DuAdmin\Mysql;

use yii\db\mysql\QueryBuilder as MySQLQueryBuilder;

class QueryBuilder extends MySQLQueryBuilder
{

    /**
     * @param \yii\db\Query $query
     * @param array $params
     * @return array
     */
    public function build($query, $params = [])
    {
        list($sql, $params) = parent::build($query, $params);

        if (($query instanceof Query || $query instanceof ActiveQuery) && $query->forUpdate) {
            $sql .= ' FOR UPDATE';
        }

        return [$sql, $params];
    }
}
