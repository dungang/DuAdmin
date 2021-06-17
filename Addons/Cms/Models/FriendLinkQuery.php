<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[FriendLink]].
 *
 * @see FriendLink
 */
class FriendLinkQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return FriendLink[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return FriendLink|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}