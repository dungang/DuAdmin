<?php
namespace app\backend\components;

use app\kit\core\BackendController;

/**
 *
 * @author dungang
 */
class SettingController extends BackendController
{
    public $default_category = 'base';
    
    public $is_backend_module = false;
    
    public $viewBasePath = '@app/backend/views/setting/';
    
    public function actions(){
        
        return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'viewName'=> $this->viewBasePath . 'index',
                'modelClass' => [
                    'class' => 'app\kit\models\SettingSearch',
                    'category'=>$this->default_category
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'viewName'=> $this->viewBasePath . 'create',
                'modelClass' => [
                    'class' => 'app\kit\models\Setting'
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'viewName'=> $this->viewBasePath . 'update',
                'modelClass' => [
                    'class' => 'app\kit\models\Setting'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'viewName'=> $this->viewBasePath . 'view',
                'modelClass' => [
                    'class' => 'app\kit\models\Setting'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\Setting'
                ]
            ],
        ];
    }
}

