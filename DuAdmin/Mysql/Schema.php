<?php

namespace DuAdmin\Mysql;

use  yii\db\mysql\Schema as MySQLSchema;

class Schema extends MySQLSchema
{

    public function createQueryBuilder()
    {
        return new QueryBuilder($this->db);
    }
}
