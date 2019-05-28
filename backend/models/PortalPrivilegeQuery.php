<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[PortalPrivilege]].
 *
 * @see PortalPrivilege
 */
class PortalPrivilegeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortalPrivilege[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortalPrivilege|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
