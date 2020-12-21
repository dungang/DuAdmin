<?php
namespace Backend\Behaviors;

use yii\base\Behavior;
use DuAdmin\Core\BaseAction;
use Backend\Models\AuthItemChild;

/**
 * action 行为，checked 权限
 *
 * @author dungang<dungang@126.com>
 * @since 2020-12-21
 */
class RoleCheckedPermissionBehavior extends Behavior
{

    public function events()
    {
        return [
            BaseAction::EVENT_BEFORE_RENDER => 'checkedPermission'
        ];
    }

    public function checkedPermission()
    {
        $action = $this->owner;
        $action->data['model']->roleId = \Yii::$app->request->get('roleId');
        if ($action->data['model']->id) {

            $itemIds = AuthItemChild::find()->where([
                'parent' => $action->data['model']->id
            ])
                ->select('child')
                ->column();
            $itemMaps = array_combine($itemIds, $itemIds);
            foreach ($action->data['models'] as &$model) {
                if (isset($itemMaps[$model['id']])) {
                    $model['checked'] = true;
                } else {
                    $model['checked'] = false;
                }
            }
        }
    }
}

