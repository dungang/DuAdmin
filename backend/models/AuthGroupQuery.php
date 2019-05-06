<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[AuthGroup]].
 *
 * @see AuthGroup
 */
class AuthGroupQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AuthGroup[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AuthGroup|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
