<?php

namespace Backend\Behaviors;

use yii\base\Behavior;
use DuAdmin\Core\BaseModel;
use yii\web\ForbiddenHttpException;

/**
 * 超管只能自己修改自己的信息
 */
class ChangeSuperBySelfBehavior extends Behavior
{
    public function events()
    {
        return [
            BaseModel::EVENT_AFTER_FIND => 'onlyDoneBySuperSelf'
        ];
    }

    public function onlyDoneBySuperSelf()
    {
        if ($this->owner->id === 1) {
            if ($this->owner->id != \Yii::$app->user->id) {
                throw new ForbiddenHttpException();
            }
        }
    }
}
