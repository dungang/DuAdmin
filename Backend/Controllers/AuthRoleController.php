<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class AuthRoleController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRoleSearch',
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
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
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRole'
                ]
            ]
        ];
    }
}
