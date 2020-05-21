<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[Rewrite]].
 *
 * @see Rewrite
 */
class RewriteQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Rewrite[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Rewrite|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
