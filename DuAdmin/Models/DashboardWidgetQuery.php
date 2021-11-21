<?php

namespace DuAdmin\Models;

/**
 * This is the ActiveQuery class for [[DashboardWidget]].
 *
 * @see DashboardWidget
 */
class DashboardWidgetQuery extends \DuAdmin\Mysql\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return DashboardWidget[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return DashboardWidget|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}