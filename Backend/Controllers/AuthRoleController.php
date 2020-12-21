<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use Backend\Models\AuthItemChild;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class AuthRoleController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => '\DuAdmin\Core\SortableListAction',
                'modelClass' => [
                    'class' => '\Backend\Models\AuthRole'
                ]
            ],
            'sorts' => [
                'class' => '\DuAdmin\Core\SortableAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ],
            'permissions' => [
                'class' => '\DuAdmin\Core\SortableListAction',
                'viaModelClass' => 'Backend\Models\AuthItemChild',
                'actionBehaviors' => [
                    'checked-permission' => '\Backend\Behaviors\RoleCheckedPermissionBehavior'
                ],
                'modelClass' => [
                    'class' => '\Backend\Models\AuthPermission'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    '\Backend\Behaviors\CleanRbacBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ]
        ];
    }

    /**
     * 角色授权
     *
     * @param string $parent
     * @param string[] $permission
     * @return mixed|number[]|string[]
     */
    public function actionAssignment($parent)
    {
        \Yii::$app->db->transaction(function ($db) use ($parent) {
            AuthItemChild::deleteAll([
                'parent' => $parent
            ]);
            $relations = [];
            $permission = \yii::$app->request->post('permission');

            foreach ($permission as $child) {
                $relations[] = [
                    $parent,
                    $child
                ];
            }

            \Yii::$app->db->createCommand()
                ->batchInsert(AuthItemChild::tableName(), [
                'parent',
                'child'
            ], $relations)->execute();

            \Yii::$app->cache->delete('rbac');
        });

        return $this->redirectOnSuccess([
            'index'
        ], '授权成功');
    }
}
