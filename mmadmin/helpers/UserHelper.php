<?php

namespace app\mmadmin\helpers;

use yii\db\Query;
use app\mmadmin\models\User;
use yii\helpers\ArrayHelper;

class UserHelper
{
    public static function memberNames($ids) {
        $query = new Query();
        $membs = $query->select('id,name')
                ->from(User::tableName())
                ->where([
                    'id' => $ids
                ])
                ->all();
        return ArrayHelper::map($membs, 'id', 'name');
    }
}