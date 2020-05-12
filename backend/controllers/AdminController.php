<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;

/**
 * 管理员管理
 */
class AdminController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\backend\forms\DynamicUser',
                    'scenario' => 'manage',
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
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
                'class' => 'app\mmadmin\core\ViewModelAction',
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\mmadmin\models\User'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\behaviors\ChangeSuperBySelfBehavior'
                ],
                'baseAttrs' => [
                    'is_admin' => 1
                ],
                'modelClass' => [
                    'class' => 'app\mmadmin\models\User'
                ]
            ]
        ];
    }
}
