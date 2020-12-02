<?php
namespace Backend\Controllers;

use DuAdmin\Core\BackendController;

/**
 * UserController implements the CRUD actions for User model.
 */
class ProfileController extends BackendController
{

    public $userActions = [
        'index'
    ];
    
    public function actions(){
        return [
            'index'=>[
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'baseAttrs'=>[
                    'id'=>\Yii::$app->user->id,
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin',
                ]
            ]
        ];
    }
}
