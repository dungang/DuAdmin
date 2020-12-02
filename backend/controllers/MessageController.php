<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\MessageSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Message'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Message'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Message'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Message'
                ]
            ],
		];
	}
}
