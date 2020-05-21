<?php
namespace app\backend\controllers;

use app\mmadmin\core\BackendController;

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
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'baseAttrs'=>[
                    'id'=>\Yii::$app->user->id,
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\Admin',
                ]
            ]
        ];
    }
}
