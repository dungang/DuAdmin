<?php

namespace app\kit\mysql;

use Yii;
use yii\db\ActiveRecord as BaseActiveRecord;

class ActiveRecord extends BaseActiveRecord
{
    /**
     * @inheritdoc
     * @return ActiveQuery|object
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }
}
