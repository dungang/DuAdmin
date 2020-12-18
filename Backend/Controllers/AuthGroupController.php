<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * AuthGroupController implements the CRUD actions for AuthGroup model.
 */
class AuthGroupController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroupSearch'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'batch-create' => [
                'class' => 'DuAdmin\Core\CreateModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AuthGroup'
                ]
            ],
		];
	}
}
