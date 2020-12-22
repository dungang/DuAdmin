<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends BackendController

{

    public function actions()
    {
        return [
            'index' => [
                'class' => '\DuAdmin\Core\SortableListAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu',
                    'isFront' => 0
                ]
            ],
            'sorts' => [
                'class' => '\DuAdmin\Core\SortableAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Menu'
                ]
            ]
        ];
    }
}
