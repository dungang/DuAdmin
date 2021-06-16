<?php

namespace Backend\Controllers;


namespace Backend\Controllers;

use Backend\Models\Admin;
use Backend\Models\AdminSearch;
use Backend\Models\AuthAssignment;
use Backend\Models\AuthRole;
use DuAdmin\Core\BackendController;
use DuAdmin\Core\BizException;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Admin 模型的控制器
 * AdministratorController 实现了常规的增删查改等行为
 */
class AdministratorController extends BackendController {

  /**
   * 列出所有的 Admin 模型.
   *
   * @return mixed
   */
  public function actionIndex() {

    $searchModel = new AdminSearch();
    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
    // 即时查询 提高性能
    $dataProvider->query->with( 'roles' );
    return $this->render( 'index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ] );

  }

  /**
   * 显示单个的 Admin 模型数据.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView( $id ) {

    return $this->render( 'view', [
        'model' => $this->findModel( $id )
    ] );

  }

  /**
   * 创建一个新的 Admin 模型.
   * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @return mixed
   */
  public function actionCreate() {

    $model = new Admin();
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      return $this->redirectSuccess( [
          'view',
          'id' => $model->id
      ], "管理员添加成功" );
    }
    return $this->render( 'create', [
        'model' => $model
    ] );

  }

  /**
   * 更新一条已经存在的 Admin 模型.
   * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionUpdate( $id ) {

    $model = $this->findModel( $id );
    $this->checkUpdateSuper( $model );
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      return $this->redirectSuccess( [
          'view',
          'id' => $model->id
      ], "管理员修改成功" );
    }
    return $this->render( 'update', [
        'model' => $model
    ] );

  }

  /**
   * 删除一条存在的 Admin 模型.
   * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
   *
   * @param integer|array $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionDelete( $id ) {

    if ( is_array( $id ) ) {
      $adminList = Admin::findAll( [
          'id' => $id
      ] );
      if ( $adminList ) {
        \Yii::$app->db->transaction( function ( $db ) use ($adminList ) {
          foreach ( $adminList as $admin ) {
            if ( ! $admin->isSuper ) {
              $admin->delete();
            }
          }
        } );
      }
    } else {
      $model = $this->findModel( $id );
      $this->checkDeleteSuper( $model );
      $model->delete();
    }
    return $this->redirect( [
        'index'
    ] );

  }

  /**
   * 管理员授权角色
   *
   * @param integer $userId
   * @param string[] $roles
   * @return mixed|number[]|string[]
   */
  public function actionAssignmentRoles( $userId ) {

    // 如果是post请求，则更新用户的角色
    if ( yii::$app->request->isPost ) {
      // 更新用户角色
      Yii::$app->db->transaction( function ( $db ) use ($userId ) {
        AuthAssignment::deleteAll( [
            'userId' => $userId
        ] );
        // 如果角色列表不为空，则更新角色
        if ( $roles = yii::$app->request->post( 'role' ) ) {
          $assignments = [ ];
          foreach ( $roles as $itemId ) {
            $assignments [] = [
                $itemId,
                $userId
            ];
          }
          \Yii::$app->db->createCommand()->batchInsert( AuthAssignment::tableName(), [
              'itemId',
              'userId'
          ], $assignments )->execute();
        }
        Yii::$app->cache->delete( 'rbac' );
      } );
      return $this->redirectSuccess( [
          'index'
      ], '授权成功' );
    } else {
      // 显示可授予的角色清单
      $models = AuthRole::find()->asArray()->orderBy( 'sort' )->all();
      if ( $models ) {
        // 标注已经授予的角色
        $admin = Admin::findOne( [
            'id' => \Yii::$app->request->get( 'userId' )
        ] );
        $roleIds = array_map( function ( $role ) {
          return $role->id;
        }, $admin->roles );
        foreach ( $models as &$model ) {
          if ( in_array( $model ['id'], $roleIds ) ) {
            $model ['checked'] = true;
          } else {
            $model ['checked'] = false;
          }
        }
      }
      return $this->render( 'roles', [
          'models' => $models,
          'userId' => $userId
      ] );
    }

  }

  protected function checkUpdateSuper( $model ) {

    // 如果管理员是超级管理员
    // 只能自己更新
    if ( $model->isSuper && $model->id != \Yii::$app->user->id ) {
      throw new BizException( "超级管理员只能被自己修改" );
    }

  }

  protected function checkDeleteSuper( $model ) {

    if ( $model->isSuper ) {
      throw new BizException( "超级管理员不能被删除" );
    }

  }

  /**
   * 根据模型的主键Id查询 Admin 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param integer $id
   * @return Admin the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel( $id ) {

    if ( ($model = Admin::findOne( [
        'id' => $id
    ] )) !== null ) {
      return $model;
    }
    throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

  }
}
