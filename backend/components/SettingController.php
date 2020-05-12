<?php
namespace app\backend\components;

use app\mmadmin\core\BackendController;

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
                'class' => 'app\mmadmin\core\ListModelsAction',
                'viewName'=> $this->viewBasePath . 'index',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\SettingSearch',
                    'category'=>$this->default_category
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'viewName'=> $this->viewBasePath . 'create',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Setting'
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'viewName'=> $this->viewBasePath . 'update',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Setting'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'viewName'=> $this->viewBasePath . 'view',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Setting'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\mmadmin\models\Setting'
                ]
            ],
        ];
    }
}

