<?php

namespace app\mmadmin\models;

/**
 * This is the ActiveQuery class for [[UserExtValue]].
 *
 * @see UserExtValue
 */
class UserExtValueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserExtValue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserExtValue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
