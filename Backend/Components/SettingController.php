<?php
namespace Backend\Components;

use DuAdmin\Core\BackendController;

/**
 *
 * @author dungang
 */
class SettingController extends BackendController
{

    public $default_category = 'base';

    /**
     * 是否后端模块
     * 历史遗留参数，可能没有意义，待定
     *
     * @todo
     * @var bool
     */
    public $is_backend_module = false;

    public $viewBasePath = '@Backend/views/setting/';

    public function actions()
    {
        return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'viewName' => $this->viewBasePath . 'index',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\SettingSearch',
                    'category' => $this->default_category
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'viewName' => $this->viewBasePath . 'create',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting',
                    'category' => $this->default_category
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'viewName' => $this->viewBasePath . 'update',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'viewName' => $this->viewBasePath . 'view',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting',
                ]
            ]
        ];
    }
}

