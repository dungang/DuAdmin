<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;
use Backend\Models\AuthAssignment;

/**
 * 管理员管理
 */
class AdministratorController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => '\DuAdmin\Core\ListModelsAction',
                'withModels' => [
                    'roles'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AdminSearch'
                ]
            ],
            'roles' => [
                'class' => '\DuAdmin\Core\SortableListAction',
                'actionBehaviors' => [
                    'checked-roles' => '\Backend\Behaviors\AdminCheckedRoleBehavior'
                ],
                'modelClass' => [
                    'class' => '\Backend\Models\AuthRole'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    'set-password' => 'DuAdmin\Behaviors\PasswordBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'Backend\Behaviors\ChangeSuperBySelfBehavior',
                    'set-password' => 'DuAdmin\Behaviors\PasswordBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'Backend\Behaviors\ChangeSuperBySelfBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ]
        ];
    }

    /**
     * 管理员授权角色
     *
     * @param integer $userId
     * @param string[] $roles
     * @return mixed|number[]|string[]
     */
    public function actionAssignment($userId)
    {
        \Yii::$app->db->transaction(function ($db) use ($userId) {

            AuthAssignment::deleteAll([
                'userId' => $userId
            ]);

            if ($roles = \yii::$app->request->post('role')) {

                $assignments = [];

                foreach ($roles as $itemId) {
                    $assignments[] = [
                        $itemId,
                        $userId
                    ];
                }

                \Yii::$app->db->createCommand()
                    ->batchInsert(AuthAssignment::tableName(), [
                    'itemId',
                    'userId'
                ], $assignments)
                    ->execute();
            }

            \Yii::$app->cache->delete('rbac');
        });

        return $this->redirectOnSuccess([
            'index'
        ], '授权成功');
    }
}
