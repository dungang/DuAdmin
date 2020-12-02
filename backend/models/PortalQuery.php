<?php

namespace Backend\Models;

/**
 * This is the ActiveQuery class for [[Portal]].
 *
 * @see Portal
 */
class PortalQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Portal[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Portal|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
