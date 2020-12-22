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
                'modelImmutableAttrs' => [
                    'category' => $this->default_category
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\SettingSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'viewName' => $this->viewBasePath . 'create',
                'modelImmutableAttrs' => [
                    'category' => $this->default_category
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'viewName' => $this->viewBasePath . 'update',
                'modelImmutableAttrs' => [
                    'category' => $this->default_category
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'viewName' => $this->viewBasePath . 'view',
                'modelImmutableAttrs' => [
                    'category' => $this->default_category
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelImmutableAttrs' => [
                    'category' => $this->default_category
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Setting'
                ]
            ]
        ];
    }
}

