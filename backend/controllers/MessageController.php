<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;


/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\MessageSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
		];
	}
}
