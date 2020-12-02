<?php

namespace app\backend\controllers;

use app\mmadmin\core\BackendController;

/**
 * 管理员管理
 */
class AdministratorController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\mmadmin\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\backend\models\AdminSearch'
                ]
            ],
            'create' => [
                'class' => 'app\mmadmin\core\CreateModelAction',
                'modelBehaviors' => [
                    'set-password' => 'app\mmadmin\behaviors\PasswordBehavior',
                    'upload-avatar' => function(){
                        return $this->getUploadAvatarBehavior();
                    }
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\Admin',
                ]
            ],
            'update' => [
                'class' => 'app\mmadmin\core\UpdateModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\behaviors\ChangeSuperBySelfBehavior',
                    'set-password' => 'app\mmadmin\behaviors\PasswordBehavior',
                    'upload-avatar' => function(){
                        return $this->getUploadAvatarBehavior();
                    }
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\Admin'
                ]
            ],
            'view' => [
                'class' => 'app\mmadmin\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\backend\models\Admin'
                ]
            ],
            'delete' => [
                'class' => 'app\mmadmin\core\DeleteModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\behaviors\ChangeSuperBySelfBehavior'
                ],
                'modelClass' => [
                    'class' => 'app\backend\models\Admin'
                ]
            ]
        ];
    }


    protected function getUploadAvatarBehavior()
    {
        return [
            'class' => 'app\mmadmin\behaviors\UploadedFileBehavior',
            'fields' => [
                'avatar' => [
                    'thumbnails' => [
                        [
                            'width' => 200,
                            'height' => 200,
                            'mode' => 'inset'
                        ]
                    ],
                    'mode' => 'inset'
                ]
            ]
        ];
    }
}
