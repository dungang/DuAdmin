<?php

namespace Backend\Models;

/**
 * This is the ActiveQuery class for [[ActionLog]].
 *
 * @see ActionLog
 */
class ActionLogQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ActionLog[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ActionLog|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}