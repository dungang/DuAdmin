<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;


/**
 * UserExtPropertyController implements the CRUD actions for UserExtProperty model.
 */
class UserExtPropertyController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserExtPropertySearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserExtProperty'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserExtProperty'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserExtProperty'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserExtProperty'
                ]
            ],
		];
	}
}
