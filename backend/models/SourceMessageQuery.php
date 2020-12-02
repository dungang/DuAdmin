<?php

namespace Backend\Models;

/**
 * This is the ActiveQuery class for [[SourceMessage]].
 *
 * @see SourceMessage
 */
class SourceMessageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return SourceMessage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return SourceMessage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
