<?php

namespace Backend\Behaviors;

use yii\base\Behavior;
use Backend\Models\Admin;

class UpdateAdminRoleBehavior extends Behavior
{
    public function events()
    {
        return [
            Admin::EVENT_AFTER_UPDATE => 'afterSave',
            Admin::EVENT_AFTER_INSERT => 'afterSave',
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
