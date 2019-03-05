<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;

/**
 * PostController implements the CRUD actions for Post model.
 */
class PostController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\PostSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'successRediretUrl'=>['index'],
                'modelClass' => [
                    'class' => 'app\kit\models\Post'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'successRediretUrl'=>['index'],
                'modelClass' => [
                    'class' => 'app\kit\models\Post'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Post'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Post'
                ]
            ],
		];
	}
}
