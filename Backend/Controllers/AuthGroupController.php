<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use Backend\Models\AuthPermission;
use Backend\Models\AuthGroup;
use yii\web\NotFoundHttpException;

/**
 * AuthGroupController implements the CRUD actions for AuthGroup model.
 */
class AuthGroupController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroupSearch',
                    'type' => 1
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'batch-create' => [
                'class' => 'DuAdmin\Core\CreateModelsAction',
                'formName' => 'AuthGroup',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'permission' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\AuthPermissionSearch',
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelImmutableAttrs' => [
                    'is_backend' => 1
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
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
