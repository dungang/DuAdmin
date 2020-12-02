<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * ActionLogController implements the CRUD actions for ActionLog model.
 */
class ActionLogController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLogSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLog'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLog'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLog'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLog'
                ]
            ],
		];
	}
}
