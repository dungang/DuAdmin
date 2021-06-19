<?php

namespace Backend\Components;

use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Setting;
use DuAdmin\Models\SettingSearch;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 *
 * @author dungang
 */
class SettingController extends BackendController {

  public $default_category = 'base';

  /**
   * 是否后端模块
   * 历史遗留参数，可能没有意义，待定
   *
   * @todo
   * @var bool
   */
  public $isBackend = false;

  public $viewBasePath = '@Backend/Views/setting/';

  /**
   * 列出所有的 Setting 模型.
   *
   * @return mixed
   */
  public function actionIndex() {

    $searchModel = new SettingSearch( [
        'category' => $this->default_category
    ] );
    $dataProvider = $searchModel->search( Yii::$app->request->queryParams );
    return $this->render( $this->viewBasePath . 'index', [
        'searchModel' => $searchModel,
        'dataProvider' => $dataProvider
    ] );

  }

  /**
   * 显示单个的 Setting 模型数据.
   *
   * @param string $name
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView( $name ) {

    return $this->render( $this->viewBasePath . 'view', [
        'model' => $this->findModel( $name )
    ] );

  }

  /**
   * 创建一个新的 Setting 模型.
   * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @return mixed
   */
  public function actionCreate() {

    $model = new Setting();
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      return $this->redirectSuccess( [
          'view',
          'id' => $model->name
      ], "添加成功" );
    }
    return $this->render( $this->viewBasePath . 'create', [
        'model' => $model
    ] );

  }

  /**
   * 更新一条已经存在的 Setting 模型.
   * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @param string $name
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionUpdate( $name ) {

    $model = $this->findModel( $name );
    // ajax表单验证
    if ( AppHelper::isAjaxValidationRequest() && $model->load( Yii::$app->request->post() ) ) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate( $model );
    }
    if ( $model->load( Yii::$app->request->post() ) && $model->save() ) {
      return $this->redirectSuccess( [
          'view',
          'id' => $model->name
      ], "修改成功" );
    }
    return $this->render( $this->viewBasePath . 'update', [
        'model' => $model
    ] );

  }

  /**
   * 删除一条存在的 Setting 模型.
   * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
   *
   * @param string $name
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionDelete( $name ) {

    if ( is_array( $name ) ) {
      $modelList = Setting::findAll( [
          'name' => $name
      ] );
      if ( $modelList ) {
        foreach ( $modelList as $model ) {
          $model->delete();
        }
      }
    } else {
      $this->findModel( $name )->delete();
    }
    return $this->redirect( [
        'index'
    ] );

  }

  /**
   * 根据模型的主键Id查询 Setting 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param string $name
   * @return Setting the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel( $name ) {

    if ( ($model = Setting::findOne( [
        'name' => $name
    ] )) !== null ) {
      return $model;
    }
    throw new NotFoundHttpException( Yii::t( 'app', 'The requested page does not exist.' ) );

  }
}

