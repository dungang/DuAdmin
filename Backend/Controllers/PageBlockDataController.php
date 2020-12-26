<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;


/**
 * PageBlockDataController implements the CRUD actions for PageBlockData model.
 */
class PageBlockDataController extends BackendController
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
                    'class' => 'DuAdmin\Models\PageBlockDataSearch'
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
                    'class' => 'DuAdmin\Models\PageBlockData'
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
                    'class' => 'DuAdmin\Models\PageBlockData'
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
                    'class' => 'DuAdmin\Models\PageBlockData'
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
                    'class' => 'DuAdmin\Models\PageBlockData'
                ]
            ],
		];
	}
}
