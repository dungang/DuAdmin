<?php

namespace Backend\Models;

/**
 * This is the ActiveQuery class for [[UserSocial]].
 *
 * @see UserSocial
 */
class UserSocialQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return UserSocial[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return UserSocial|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
