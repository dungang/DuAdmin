<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[GenTableColumn]].
 *
 * @see GenTableColumn
 */
class GenTableColumnQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return GenTableColumn[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return GenTableColumn|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}