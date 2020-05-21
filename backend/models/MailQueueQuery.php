<?php

namespace app\backend\models;

/**
 * This is the ActiveQuery class for [[MailQueue]].
 *
 * @see MailQueue
 */
class MailQueueQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return MailQueue[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MailQueue|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
