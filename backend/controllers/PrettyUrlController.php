<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;


/**
 * PrettyUrlController implements the CRUD actions for Rewrite model.
 */
class PrettyUrlController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\RewriteSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Rewrite'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Rewrite'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Rewrite'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Rewrite'
                ]
            ],
		];
	}
}
