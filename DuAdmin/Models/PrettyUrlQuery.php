<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[PrettyUrl]].
 *
 * @see PrettyUrl
 */
class PrettyUrlQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return PrettyUrl[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return PrettyUrl|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}