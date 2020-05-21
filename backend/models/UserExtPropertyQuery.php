<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[UserExtProperty]].
 *
 * @see UserExtProperty
 */
class UserExtPropertyQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserExtProperty[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserExtProperty|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
