<?php

namespace Addons\ChinaRegion\Models;

/**
 * This is the ActiveQuery class for [[ChinaRegion]].
 *
 * @see ChinaRegion
 */
class ChinaRegionQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ChinaRegion[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ChinaRegion|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}