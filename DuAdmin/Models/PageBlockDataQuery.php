<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[PageBlockData]].
 *
 * @see PageBlockData
 */
class PageBlockDataQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PageBlockData[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PageBlockData|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}