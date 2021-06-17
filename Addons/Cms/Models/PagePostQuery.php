<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[PagePost]].
 *
 * @see PagePost
 */
class PagePostQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PagePost[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PagePost|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}