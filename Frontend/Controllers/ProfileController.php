<?php
namespace Frontend\Controllers;

use DuAdmin\Core\FrontendController;

/**
 * UserController implements the CRUD actions for User model.
 */
class ProfileController extends FrontendController
{

    public $userActions = [
        'index'
    ];
    
    public function actions(){
        return [
            'index'=>[
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelImmutableAttrs'=>[
                    'id'=>\Yii::$app->user->id,
                ],
                'modelClass' => [
                    'class' => 'Frontend\Models\User',
                ]
            ]
        ];
    }
}
