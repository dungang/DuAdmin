<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;
use app\mmadmin\models\AuthPermission;
use app\backend\models\AuthGroup;
use yii\web\NotFoundHttpException;

/**
 * AuthGroupController implements the CRUD actions for AuthGroup model.
 */
class AuthAdminGroupController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroupSearch',
                    'type' => 1
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'batch-create' => [
                'class' => 'app\mmadmin\core\CreateModelsAction',
                'formName' => 'AuthGroup',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'permission' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\AuthPermissionSearch',
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'baseAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
        ];
    }

    /**
     * 分配权限到组
     *
     * @param string $group_name
     * @param integer $type
     * @return string|\yii\web\Response
     */
    public function actionAssign($group_name, $type = 1)
    {

        if (($group = AuthGroup::findOne(['name' => $group_name])) && $group->is_backend == 1) {
            if ($names = \Yii::$app->request->post('name')) {
                AuthPermission::updateAll(['group_name' => $group_name], [
                    'name' => $names
                ]);
                return $this->redirectOnSuccess(['permission', 'AuthPermissionSearch[group_name]' => $group_name]);
            }

            $unAssignedItems = AuthPermission::allMap(
                'name',
                'description',
                ['and', ['type' => $type], ['or', ['<>', 'group_name', $group_name], 'group_name is null']]
            );
            $assignedItems = AuthPermission::allMap('name', 'description', ['type' => $type, 'group_name' => $group_name]);

            return $this->render('assign', [
                'group_name' => $group_name,
                'type' => $type,
                'unAssignedItems' => $unAssignedItems,
                'assignedItems' => $assignedItems
            ]);
        }
        throw new NotFoundHttpException('管理员授权组:' . $group_name . ',不存在');
    }
}
