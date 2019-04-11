<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;


/**
 * PageController implements the CRUD actions for Page model.
 */
class PageController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\PageSearch'
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'successRediretUrl'=>['update','id'=>'id'],
                'modelClass' => [
                    'class' => 'app\kit\models\Page'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Page'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Page'
                ]
            ],
		];
	}
}
