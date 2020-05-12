<?php

namespace app\mmadmin\mysql;

use Yii;
use yii\db\ActiveRecord as OriginActiveRecord;

/**
 * 支持select for update 的activerecord
 * 
 * @method \app\mmadmin\mysql\ActiveQuery findByCondition($condition)
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
    public static function findOneForUpdate($condition)
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

    /**
     * Executes callback provided in a transaction.
     *
     * @param callable $callback a valid PHP callback that performs the job. Accepts connection instance as parameter.
     * @param string|null $isolationLevel The isolation level to use for this transaction.
     * See [[Transaction::begin()]] for details.
     * @throws \Exception|\Throwable if there is any exception during query. In this case the transaction will be rolled back.
     * @return mixed result of callback function
     */
    public static function transaction(callable $callback, $isolationLevel = null) 
    {
        return Yii::$app->db->transaction($callback,$isolationLevel);
    }
}
