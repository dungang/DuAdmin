<?php

namespace app\backend\controllers;

use app\kit\core\BackendController;
use app\kit\models\AuthPermission;

/**
 * AuthGroupController implements the CRUD actions for AuthGroup model.
 */
class AuthGroupController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroupSearch',
                    'type' => 1,
                ]
            ],
            'create' => [
                'class' => 'app\kit\core\CreateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'batch-create' => [
                'class' => 'app\kit\core\CreateModelsAction',
                'formName' => 'AuthGroup',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'permission' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\AuthPermissionSearch',
                ]
            ],
            'update' => [
                'class' => 'app\kit\core\UpdateModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AuthGroup'
                ]
            ],
        ];
    }

    /**
     * 分配权限到组
     *
     * @param string $group_name
     * @param integer $type
     * @return string|yii\web\Response
     */
    public function actionAssign($group_name, $type = 1)
    {

        if ($names = \Yii::$app->request->post('name')) {
            AuthPermission::updateAll(['group_name' => $group_name], [
                'name' => $names
            ]);
            return $this->redirectOnSuccess(['permission', 'AuthPermissionSearch[group_name]' => $group_name]);
        }

        $unAssignedItems = AuthPermission::allMap('name', 'description', 
            ['and',['type'=>$type],['or',['<>', 'group_name', $group_name],'group_name is null']]
        );
        $assignedItems = AuthPermission::allMap('name', 'description', ['type'=>$type,'group_name' => $group_name]);

        return $this->render('assign', [
            'group_name' => $group_name,
            'type' => $type,
            'unAssignedItems' => $unAssignedItems, 
            'assignedItems' => $assignedItems
            ]);
    }
}
