<?php

namespace Backend\Components;

use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Models\Navigation;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * NavigationController implements the CRUD actions for Navigation model.
 */
class NavigationController extends BackendController
{

  public $appName = 'frontend';

  public $viewBasePath = '@Backend/Views/navigation/';

  public function actions()
  {

    return [
      'sorts' => [
        'class' => '\DuAdmin\Core\SortableAction',
        'modelClass' => 'DuAdmin\Models\Navigation'
      ]
    ];
  }

  /**
   * 列出所有的 Navigation 模型.
   *
   * @return mixed
   */
  public function actionIndex()
  {

    $models = Navigation::find()->where([
      'app' => $this->appName
    ])->asArray()->orderBy('sort')->all();
    return $this->render($this->viewBasePath . 'index', [
      'models' => $models,
      'app' => $this->appName
    ]);
  }

  /**
   * 显示单个的 Navigation 模型数据.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {

    return $this->render($this->viewBasePath . 'view', [
      'model' => $this->findModel($id)
    ]);
  }

  /**
   * 创建一个新的 Navigation 模型.
   * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @return mixed
   */
  public function actionCreate()
  {

    $model = new Navigation([
      'app' => $this->appName,
      'pid' => 0
    ]);
    // ajax表单验证
    if (AppHelper::isAjaxValidationRequest() && $model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate($model);
    }
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirectSuccess(Yii::$app->request->referrer, "添加成功");
    }
    return $this->render($this->viewBasePath . 'create', [
      'model' => $model
    ]);
  }

  /**
   * 更新一条已经存在的 Navigation 模型.
   * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionUpdate($id)
  {

    $model = $this->findModel($id);
    // ajax表单验证
    if (AppHelper::isAjaxValidationRequest() && $model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate($model);
    }
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirectSuccess([
        'view',
        'id' => $model->id
      ], "修改成功");
    }
    return $this->render($this->viewBasePath . 'update', [
      'model' => $model
    ]);
  }

  /**
   * 删除一条存在的 Navigation 模型.
   * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionDelete($id)
  {

    if (is_array($id)) {
      $modelList = Navigation::findAll([
        'id' => $id
      ]);
      if ($modelList) {
        foreach ($modelList as $model) {
          $model->delete();
        }
      }
    } else {
      $this->findModel($id)->delete();
    }
    return $this->redirect([
      'index'
    ]);
  }

  /**
   * 根据模型的主键Id查询 Navigation 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param integer $id
   * @return Navigation the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel($id)
  {

    if (($model = Navigation::findOne([
      'id' => $id,
      'app' => $this->appName
    ])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
