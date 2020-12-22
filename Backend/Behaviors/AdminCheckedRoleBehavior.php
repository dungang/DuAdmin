<?php
namespace Backend\Behaviors;

use yii\base\Behavior;
use DuAdmin\Core\BaseAction;
use Backend\Models\Admin;

/**
 * 管理元角色checked
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-22
 */
class AdminCheckedRoleBehavior extends Behavior
{

    public function events()
    {
        return [
            BaseAction::EVENT_BEFORE_RENDER => 'checkRoles'
        ];
    }

    public function checkRoles()
    {
        $action = $this->owner;
        $admin = Admin::findOne([
            'id' => \Yii::$app->request->get('userId')
        ]);
        
        $roleIds = array_map(function ($role) {
            return $role->id;
        }, $admin->roles);

        foreach ($action->data['models'] as &$model) {
            if (in_array($model['id'], $roleIds)) {
                $model['checked'] = true;
            } else {
                $model['checked'] = false;
            }
        }
    }
}

