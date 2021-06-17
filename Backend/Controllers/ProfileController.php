<?php

namespace Backend\Controllers;

use Backend\Models\Admin;
use DuAdmin\Core\BackendController;
use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class ProfileController extends BackendController {

  public $userActions = [
      'index'
  ];

  public function actionIndex() {

    $model = Admin::findOne( Yii::$app->user->id );
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      return $this->redirectSuccess( [
          'profile'
      ], '修改成功' );
    }
    return $this->render( 'index', [
        'model' => $model
    ] );

  }
}
