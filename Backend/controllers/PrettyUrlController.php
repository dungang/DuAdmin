<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * PrettyUrlController implements the CRUD actions for Rewrite model.
 */
class PrettyUrlController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\RewriteSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Rewrite'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Rewrite'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Rewrite'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Rewrite'
                ]
            ],
		];
	}
}
