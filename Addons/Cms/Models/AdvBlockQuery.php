<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[AdvBlock]].
 *
 * @see AdvBlock
 */
class AdvBlockQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return AdvBlock[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return AdvBlock|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}