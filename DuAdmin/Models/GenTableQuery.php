<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[GenTable]].
 *
 * @see GenTable
 */
class GenTableQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GenTable[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GenTable|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}