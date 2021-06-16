<?php

namespace Backend\Controllers;

use Backend\Forms\AuthPermissionForm;
use Backend\Models\AuthPermission;
use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Rbac\Item;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * AuthPermission 模型的控制器
 * AuthPermissionController 实现了常规的增删查改等行为
 */
class AuthPermissionController extends BackendController {

  public function actions() {

    return [
        'sorts' => [
            'class' => '\DuAdmin\Core\SortableAction',
            'viaModelClass' => 'Backend\Models\AuthItemChild',
            'modelClass' => 'Backend\Models\AuthPermission'
        ]
    ];

  }

  /**
   * 列出所有的 AuthPermission 模型.
   *
   * @return mixed
   */
  public function actionIndex() {

    $models = AuthPermission::find()->with( 'parent' )->orderBy( 'sort' )->all();
    if ( $models ) {
      $models = array_map( function ( $model ) {
        $attributes = $model->attributes;
        if ( $model->parent && $model->parent->type == Item::TYPE_PERMISSION ) {
          $attributes ['pid'] = $model->parent->id;
        }
        return $attributes;
      }, $models );
    }
    return $this->render( 'index', [
        'models' => $models
    ] );

  }

  /**
   * 显示单个的 AuthPermission 模型数据.
   *
   * @param string $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView( $id ) {

    return $this->render( 'view', [
        'model' => $this->findModel( $id )
    ] );

  }

  /**
   * 创建一个新的 AuthPermission 模型.
   * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @return mixed
   */
  public function actionCreate() {

    $model = new AuthPermissionForm();
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      Yii::$app->cache->delete( 'rbac' );
      return $this->redirectSuccess( [
          'view',
          'id' => $model->id
      ], "添加成功" );
    }
    return $this->render( 'create', [
        'model' => $model
    ] );

  }

  /**
   * 更新一条已经存在的 AuthPermission 模型.
   * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @param string $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionUpdate( $id ) {

    $model = AuthPermissionForm::findModel( $id );
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      Yii::$app->cache->delete( 'rbac' );
      return $this->redirectSuccess( [
          'view',
          'id' => $model->id
      ], "修改成功" );
    }
    return $this->render( 'update', [
        'model' => $model
    ] );

  }

  /**
   * 删除一条存在的 AuthPermission 模型.
   * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
   *
   * @param string $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionDelete( $id ) {

    if ( is_array( $id ) ) {
      $modelList = AuthPermission::findAll( [
          'id' => $id
      ] );
      if ( $modelList ) {
        foreach ( $modelList as $model ) {
          $model->delete();
        }
      }
    } else {
      $this->findModel( $id )->delete();
    }
    Yii::$app->cache->delete( 'rbac' );
    return $this->redirect( [
        'index'
    ] );

  }

  /**
   * 根据模型的主键Id查询 AuthPermission 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param string $id
   * @return AuthPermission the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel( $id ) {

    if ( ($model = AuthPermission::findOne( [
        'id' => $id
    ] )) !== null ) {
      return $model;
    }
    throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

  }
}
