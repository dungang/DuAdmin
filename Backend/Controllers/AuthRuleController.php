<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * AuthRuleController implements the CRUD actions for AuthRule model.
 */
class AuthRuleController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRuleSearch'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRule'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRule'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRule'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                'modelBehaviors' => [
                    'Backend\Behaviors\CleanRbacBehavior',
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\AuthRule'
                ]
            ],
		];
	}
}
