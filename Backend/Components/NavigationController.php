<?php

namespace Backend\Components;

use DuAdmin\Core\BackendController;


/**
 * NavigationController implements the CRUD actions for Navigation model.
 */
class NavigationController extends BackendController
{
    public $appName = 'frontend';
    
    public $viewBasePath = '@Backend/views/navigation/';
    
	public function actions(){
		return [
		    'index' => [
		        'class' => '\DuAdmin\Core\SortableListAction',
		        'modelImmutableAttrs' => [
		            'app' => $this->appName
		        ],
		        'modelClass' => [
		            'class' => '\DuAdmin\Models\Navigation',
		        ]
		    ],
		    'sorts' => [
		        'class' => '\DuAdmin\Core\SortableAction',
		        'modelImmutableAttrs' => [
		            'app' => $this->appName
		        ],
		        'modelClass' => [
		            'class' => 'DuAdmin\Models\Navigation'
		        ]
		    ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                'modelImmutableAttrs' => [
                    'app' => $this->appName
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Navigation'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                'modelImmutableAttrs' => [
                    'app' => $this->appName
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Navigation'
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                'modelImmutableAttrs' => [
                    'app' => $this->appName
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Navigation'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelsAction',
                // 'modelBehaviors' => [],
                // 'actionBehaviors' => [],
                // 'modelScenario' => 'default',
                // 'successRediretUrl' => false,
                // 'successMsg' => null,
                'modelImmutableAttrs' => [
                    'app' => $this->appName
                ],
                'modelClass' => [
                    'class' => 'DuAdmin\Models\Navigation'
                ]
            ],
		];
	}
}
