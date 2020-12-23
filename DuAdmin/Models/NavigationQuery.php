<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[Navigation]].
 *
 * @see Navigation
 */
class NavigationQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Navigation[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Navigation|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}