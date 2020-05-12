<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;


/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessageSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
		];
	}
}
