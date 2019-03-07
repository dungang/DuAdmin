<?php
namespace app\backend\controllers;

use app\kit\core\BackendController;
use yii\web\NotFoundHttpException;
use app\kit\models\User;
use app\backend\forms\UserForm;
use Yii;

class MemberController extends BackendController
{
    public function actions()
    {
        return [
            'index' => [
                'class' => 'app\kit\core\ListModelsAction',
                'modelClass' => [
                    'class' => 'app\kit\models\UserSearch'
                ]
            ],
            'view' => [
                'class' => 'app\kit\core\ViewModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\User'
                ]
            ],
            'delete' => [
                'class' => 'app\kit\core\DeleteModelAction',
                'modelClass' => [
                    'class' => 'app\kit\models\User'
                ]
            ]
        ];
    }
    
    
    
    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new UserForm();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectOnSuccess([
                'index'
            ]);
        }
        
        return $this->render('create', [
            'model' => $model
        ]);
    }
    
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $form = new UserForm();
        $form->loadUser($model);
        if ($form->load(Yii::$app->request->post()) && $form->save()) {
            return $this->redirectOnSuccess([
                'index'
            ]);
        }
        
        return $this->render('update', [
            'model' => $form
        ]);
    }
    
    
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }
        
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}

