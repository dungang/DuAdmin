<?php
namespace app\backend\controllers;

use app\mmadmin\core\BackendController;

/**
 * AuthPermissionController implements the CRUD actions for AuthPermission model.
 */
class AuthPermissionController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\PermissionListBehavior',
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermissionSearch',
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ],
            'batch-create' => [
                'class' => 'app\mmadmin\core\CreateModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ],
            'batch-update' => [
                'class' => 'app\mmadmin\core\UpdateModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelsAction',
                'modelBehaviors' => [
                    'app\backend\behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\AuthPermission'
                ]
            ]
        ];
    }
}
