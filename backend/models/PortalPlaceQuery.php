<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[PortalPlace]].
 *
 * @see PortalPlace
 */
class PortalPlaceQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PortalPlace[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PortalPlace|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
