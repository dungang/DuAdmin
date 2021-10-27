<?php

namespace Backend\Controllers;

use Backend\Models\CronSearch;
use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use DuAdmin\Helpers\CrontabHelper;
use DuAdmin\Models\Cron;
use Yii;
use yii\httpclient\Client;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Cron 模型的控制器
 * CronController 实现了常规的增删查改等行为
 */
class CronController extends BackendController
{

  public function init()
  {

    parent::init();
    $this->guestActions = [
      'run'
    ];
  }

  public function actions()
  {

    return [
      'run' => [
        'class' => '\DuAdmin\Core\LoopAction',
        'beforeRunCallback' => [
          $this,
          'canStartCronProcess'
        ],
        'longPollingHandlerClass' => '\Backend\Components\CronHandler'
      ]
    ];
  }

  /**
   * 列出所有的 Cron 模型.
   *
   * @return mixed
   */
  public function actionIndex()
  {

    $searchModel = new CronSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    return $this->render('index', [
      'searchModel' => $searchModel,
      'dataProvider' => $dataProvider
    ]);
  }

  /**
   * 执行一次
   */
  public function actionOnce($id)
  {
    $task = $this->findModel($id);
    // 初始化一个异步请求的HttpClient
    $httpClient = new Client([
      'transport' => '\DuAdmin\Components\AsyncStreamTransport'
    ]);
    // 更新任务的执行时间
    $task->runAt = date('Y-m-d H:i:s');
    $task->save(false);
    $url = Yii::$app->urlManager->createAbsoluteUrl([
      '/cron-task',
      'id' => $task->id,
      'token' => $task->token
    ]);
    Yii::debug('Starting One Task : ' . $task->task . ': ' . $url, __METHOD__);
    // 发送异步请求
    $httpClient->get($url)->send();
    return $this->redirect([
      'index'
    ]);
  }

  /**
   * 显示单个的 Cron 模型数据.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException if the model cannot be found
   */
  public function actionView($id)
  {

    return $this->render('view', [
      'model' => $this->findModel($id)
    ]);
  }

  /**
   * 创建一个新的 Cron 模型.
   * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
   *
   * @return mixed
   */
  public function actionCreate()
  {

    $model = new Cron();
    // ajax表单验证
    if (AppHelper::isAjaxValidationRequest() && $model->load(Yii::$app->request->post())) {
      Yii::$app->response->format = Response::FORMAT_JSON;
      return ActiveForm::validate($model);
    }
    if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirectSuccess([
        'view',
        'id' => $model->id
      ], "添加成功");
    }
    return $this->render('create', [
      'model' => $model
    ]);
  }

  /**
   * 更新一条已经存在的 Cron 模型.
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
    return $this->render('update', [
      'model' => $model
    ]);
  }

  /**
   * 删除一条存在的 Cron 模型.
   * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
   *
   * @param integer $id
   * @return mixed
   * @throws NotFoundHttpException 如果模型没查询到
   */
  public function actionDelete($id)
  {

    if (is_array($id)) {
      $modelList = Cron::findAll([
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
   * 切换定时任务服务状态
   *
   * @return mixed|number[]|string[]
   */
  public function actionSwitchService()
  {

    if (CrontabHelper::getCronStatus()) {
      CrontabHelper::unactiveCronStatus();
    } else {
      CrontabHelper::activeCronStatus();
    }
    return $this->redirectSuccess([
      'index'
    ], '切换成功');
  }

  /**
   * 处理定时器的可执行状态
   *
   * @return callable
   */
  public function canStartCronProcess()
  {

    list($status, $tracedAt, $isRunning) = CrontabHelper::prepareCronSetting();
    if ($status > 1) {
      // 表示没有cron进程在运行，需要重新启动，如果超过1800秒【半小时】没更新时间，也重新启动
      if (YII_DEBUG || $isRunning === 0 || intval($tracedAt) + 1800 < time()) {
        CrontabHelper::running();
        return true;
      }
    }
    return false;
  }

  /**
   * 根据模型的主键Id查询 Cron 模型.
   * 如果模型没有找到, 404 HTTP 异常将会抛出.
   *
   * @param integer $id
   * @return Cron the loaded model
   * @throws NotFoundHttpException 如果模型没查询到
   */
  protected function findModel($id)
  {

    if (($model = Cron::findOne([
      'id' => $id
    ])) !== null) {
      return $model;
    }
    throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
  }
}
