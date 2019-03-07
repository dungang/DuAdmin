<?php
namespace app\backend\controllers;

use app\kit\models\User;
use yii\web\NotFoundHttpException;
use app\backend\forms\UserForm;
use app\kit\core\BackendController;

/**
 * UserController implements the CRUD actions for User model.
 */
class ProfileController extends BackendController
{

    public $userActions = [
        'index'
    ];

    public function actionIndex()
    {
        $model = $this->findModel(\Yii::$app->user->id);
        $form = new UserForm();
        $form->loadUser($model);
        if ($form->load(\Yii::$app->request->post()) && $form->save()) {
            return $this->redirectOnSuccess(\Yii::$app->request->referrer, "更新成功");
        }
        return $this->render('index', [
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
