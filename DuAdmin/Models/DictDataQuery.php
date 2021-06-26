<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[DictData]].
 *
 * @see DictData
 */
class DictDataQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DictData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DictData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}