<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;

/**
 * AuthPermissionController implements the CRUD actions for AuthPermission model.
 */
class AuthPermissionController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\PermissionListBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermissionSearch',
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ],
            'batch-create' => [
                'class' => 'DuAdmin\Core\CreateModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ],
            'batch-update' => [
                'class' => 'DuAdmin\Core\UpdateModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthPermission'
                ]
            ]
        ];
    }
}
