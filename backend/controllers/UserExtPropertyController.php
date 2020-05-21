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
                    'class' => 'app\backend\models\AdminExtPropertySearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AdminExtProperty'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AdminExtProperty'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AdminExtProperty'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AdminExtProperty'
                ]
            ],
		];
	}
}
