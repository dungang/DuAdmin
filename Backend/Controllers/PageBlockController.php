<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * PageBlockController implements the CRUD actions for PageBlock model.
 */
class PageBlockController extends BackendController
{
	public function actions(){
		return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'withModels' => [],
                // 'modelImmutableAttrs' => [],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\PageBlockSearch'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'modelImmutableAttrs' => [],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\PageBlock'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'modelImmutableAttrs' => [],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\PageBlock'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'modelImmutableAttrs' => [],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\PageBlock'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                // 'modelImmutableAttrs' => [],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\PageBlock'
                ]
            ],
		];
	}
}
