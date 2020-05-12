<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;


/**
 * SourceMessageController implements the CRUD actions for SourceMessage model.
 */
class SourceMessageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessageSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\SourceMessage'
                ]
            ],
		];
	}
}
