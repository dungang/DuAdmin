<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[DictType]].
 *
 * @see DictType
 */
class DictTypeQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DictType[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DictType|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}