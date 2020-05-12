<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;


/**
 * UserExtPropertyController implements the CRUD actions for UserExtProperty model.
 */
class UserExtPropertyController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserExtPropertySearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserExtProperty'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserExtProperty'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserExtProperty'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\UserExtProperty'
                ]
            ],
		];
	}
}
