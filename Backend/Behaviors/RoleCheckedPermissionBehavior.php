<?php
namespace Backend\Behaviors;

use yii\base\Behavior;
use DuAdmin\Core\BaseAction;
use Backend\Models\AuthItemChild;
use Backend\Models\AuthRole;

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
        //多模型的时候使用formName区分不同的模型参数
        //很关键，不然导致参数交叉赋值
        //发生该问题的情况是，
        // baseAction的部分方法是贪婪识别参数的，尽量保证参数都被模型加载
        $roleModel = new AuthRole();
        $roleModel->load(\Yii::$app->request->get());
        $action->data['role'] = $roleModel;
        if ($roleModel->id) {
            $itemIds = AuthItemChild::find()->where([
                'parent' => $roleModel->id
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

