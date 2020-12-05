<?php

namespace Backend\Behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use Backend\Models\AuthGroup;

/**
 * 权限列表查询行为，通过isBackend参数动态绑定AuthPermissionSearch的group_name的查询值
 * 并在视图中添加参数groups
 * 在权限管理控制器中被使用
 */
class PermissionListBehavior extends Behavior
{
    public $isBackend = 1;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate'
        ];
    }

    public function beforeValidate($event)
    {
        $isBackend = \Yii::$app->request->get('isBackend',-1);

        switch ($isBackend) {
            case 1:
            case 0:
                $this->bindGroupName($isBackend);
                break;
            default:
                \Yii::$app->view->params['groups']  = AuthGroup::allIdToName('name', 'title');
        }
    }

    protected function bindGroupName($isBackend)
    {
        $groups = AuthGroup::allIdToName('name', 'title', ['isBackend' => $isBackend]);
        \Yii::$app->view->params['groups'] = $groups;
        if (empty($this->owner->group_name)) {
            $group_names = array_keys($groups);
            if ($group_names) {
                $this->owner->_groups = array_keys($groups);
            } else {
                $this->owner->_groups = '__group_name__';
            }
        }
    }
}
