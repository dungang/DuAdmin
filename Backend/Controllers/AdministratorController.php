<?php

namespace Backend\Controllers;

use DuAdmin\Core\BackendController;

/**
 * 管理员管理
 */
class AdministratorController extends BackendController
{

    public function actions()
    {
        return [
            'index' => [
                'class' => 'DuAdmin\Core\ListModelsAction',
                'modelClass' => [
                    'class' => 'Backend\Models\AdminSearch'
                ]
            ],
            'create' => [
                'class' => 'DuAdmin\Core\CreateModelAction',
                'modelBehaviors' => [
                    'set-password' => 'DuAdmin\Behaviors\PasswordBehavior',
                    'upload-avatar' => function(){
                        return $this->getUploadAvatarBehavior();
                    }
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin',
                ]
            ],
            'update' => [
                'class' => 'DuAdmin\Core\UpdateModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\Behaviors\ChangeSuperBySelfBehavior',
                    'set-password' => 'DuAdmin\Behaviors\PasswordBehavior',
                    'upload-avatar' => function(){
                        return $this->getUploadAvatarBehavior();
                    }
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ],
            'view' => [
                'class' => 'DuAdmin\Core\ViewModelAction',
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ],
            'delete' => [
                'class' => 'DuAdmin\Core\DeleteModelAction',
                'modelBehaviors' => [
                    'super-do-self' => 'app\backend\Behaviors\ChangeSuperBySelfBehavior'
                ],
                'modelClass' => [
                    'class' => 'Backend\Models\Admin'
                ]
            ]
        ];
    }


    protected function getUploadAvatarBehavior()
    {
        return [
            'class' => 'DuAdmin\Behaviors\UploadedFileBehavior',
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
