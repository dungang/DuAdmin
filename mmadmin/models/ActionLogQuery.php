<?php

namespace app\mmadmin\models;

/**
 * This is the ActiveQuery class for [[ActionLog]].
 *
 * @see ActionLog
 */
class ActionLogQuery extends \yii\db\ActiveQuery
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