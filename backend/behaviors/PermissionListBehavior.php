<?php

namespace app\backend\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use app\backend\models\AuthGroup;

class PermissionListBehavior extends Behavior
{
    public $is_backend = 1;

    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeValidate'
        ];
    }

    public function beforeValidate($event)
    {
        $is_backend = \Yii::$app->request->get('is_backend');

        switch ($is_backend) {
            case 1:
            case 0:
                $this->bindGroupName($is_backend);
                break;
            default:
                \Yii::$app->view->params['groups']  = AuthGroup::allIdToName('name', 'title');
        }
    }

    protected function bindGroupName($is_backend)
    {
        $groups = AuthGroup::allIdToName('name', 'title', ['is_backend' => $is_backend]);
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
