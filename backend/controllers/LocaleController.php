<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * LocaleController implements the CRUD actions for SourceMessage model.
 */
class LocaleController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\SourceMessageSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\SourceMessage'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\SourceMessage'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\SourceMessage'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\SourceMessage'
                ]
            ],
		];
	}
}
