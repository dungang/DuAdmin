<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[PageBlock]].
 *
 * @see PageBlock
 */
class PageBlockQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PageBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PageBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}