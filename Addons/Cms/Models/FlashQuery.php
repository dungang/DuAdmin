<?php

namespace Addons\Cms\Models;

/**
 * This is the ActiveQuery class for [[Flash]].
 *
 * @see Flash
 */
class FlashQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Flash[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Flash|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}