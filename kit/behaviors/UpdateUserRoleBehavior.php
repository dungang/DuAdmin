<?php

namespace app\kit\behaviors;

use yii\base\Behavior;
use app\kit\models\User;

class UpdateUserRoleBehavior extends Behavior
{
    public function events()
    {
        return [
            User::EVENT_AFTER_UPDATE => 'afterSave',
            User::EVENT_AFTER_INSERT => 'afterSave',
        ];
    }

    public function afterSave($event)
    {
        if ($event->changedAttributes && isset($event->changedAttributes['role'])) {
            $user_id = $this->owner->id;
            \Yii::$app->authManager->revokeAll($user_id);
            $role_names = explode(',', $this->owner->role);
            foreach ($role_names as $role_name) {
                $role = \Yii::$app->authManager->getRole($role_name);
                \Yii::$app->authManager->assign($role, $user_id);
            }
        }
    }
}
