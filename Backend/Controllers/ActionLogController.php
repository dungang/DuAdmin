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
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\ActionLog'
                ]
            ],
		];
	}
}
