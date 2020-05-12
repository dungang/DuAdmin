<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;


/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\MessageSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Message'
                ]
            ],
		];
	}
}
