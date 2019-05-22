<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;

/**
 * 管理员管理
 */
class AdminController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\kit\models\UserSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\forms\DynamicUser',
                    'scenario' => 'manage',
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\behaviors\ChangeSuperBySelfBehavior'
                ],
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\forms\DynamicUser',
                    'scenario' => 'manage',
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\kit\models\User'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\behaviors\ChangeSuperBySelfBehavior'
                ],
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\kit\models\User'
                ]
            ]
        ];
    }
}
