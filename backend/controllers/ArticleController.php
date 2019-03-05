<?php
namespace app\backend\controllers;

use app\kit\core\FrontendController;

class ArticleController extends FrontendController
{
    public function init()
    {
        parent::init();
        $this->guestActions = [
            'index',
            'view'
        ];
    }
    
    public function actions(){
        return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\PostSearch'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Post'
                ]
            ],
        ];
    }
}

