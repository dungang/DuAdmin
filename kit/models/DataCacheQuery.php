<?php

namespace app\kit\models;

/**
 * This is the ActiveQuery class for [[DataCache]].
 *
 * @see DataCache
 */
class DataCacheQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DataCache[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DataCache|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
