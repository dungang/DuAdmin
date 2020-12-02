<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * PortalController implements the CRUD actions for Portal model.
 */
class PortalController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\PortalSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Portal'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Portal'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Portal'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Portal'
                ]
            ],
		];
	}
}
