<?php
namespace Frontend\Controllers;

use Yii;
use DuAdmin\Core\FrontendController;
use Frontend\Models\User;

/**
 * UserController implements the CRUD actions for User model.
 */
class ProfileController extends FrontendController
{

    public $userActions = [
        'index'
    ];
    
  public function actionIndex() {

    $model = User::findOne( Yii::$app->user->id );
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
