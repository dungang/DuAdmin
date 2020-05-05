<?php

namespace app\kit\mysql;

use Yii;
use yii\db\ActiveRecord as OriginActiveRecord;

/**
 * 支持select for update 的activerecord
 * 
 * @method \app\kit\mysql\ActiveQuery findByCondition($condition)
 */
class ActiveRecord extends OriginActiveRecord
{
    /**
     * @inheritdoc
     * @return ActiveQuery|object
     */
    public static function find()
    {
        return Yii::createObject(ActiveQuery::className(), [get_called_class()]);
    }

    /**
     * @param $condition mixed
     * @return static|null ActiveRecord instance matching the condition, or `null` if nothing matches.
     */
    public function findOneForUpdate($condition)
    {
        return static::findByCondition($condition)->forUpdate()->one();
    }

    /**
     * @param $condition mixed
     * @return static[] an array of ActiveRecord instances, or an empty array if nothing matches.
     */
    public static function findAllForUpdate($condition)
    {
        return static::findByCondition($condition)->forUpdate()->all();
    }
}
