<?php

namespace backend\Behaviors;

use yii\base\Behavior;
use DuAdmin\Core\BaseModel;

class CleanRbacBehavior extends Behavior
{
    public function events()
    {
        return [
            BaseModel::EVENT_AFTER_DELETE =>'cleanRbac',
            BaseModel::EVENT_AFTER_INSERT => 'cleanRbac',
            BaseModel::EVENT_AFTER_UPDATE => 'cleanRbac',
        ];
    }

    public function cleanRbac(){
        \Yii::$app->cache->delete('rbac');
    }
}