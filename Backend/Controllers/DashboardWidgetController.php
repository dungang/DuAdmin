<?php

namespace Backend\Controllers;

use Yii;
use yii\web\NotFoundHttpException;
use DuAdmin\Models\DashboardWidget;
use DuAdmin\Models\DashboardWidgetSearch;
use DuAdmin\Core\BackendController;
use yii\helpers\Json;

/**
 * DashboardWidget 模型的控制器
 * DashboardWidgetController 实现了常规的增删查改等行为
 */
class DashboardWidgetController extends BackendController
{
    /**
     * 请求action 方法设置
     * @var array
     */
    public $verbsActions = ['delete' => ['POST']];

    public $userAction = ['render'];

    /**
     * 列出所有的 DashboardWidget 模型.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DashboardWidgetSearch();
        $queryParams = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个的 DashboardWidget 模型数据.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * 创建一个新的 DashboardWidget 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DashboardWidget();

        // ajax表单验证
        if (($error = $this->ajaxValidation($model)) !== false) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post())) {
            return Yii::$app->db->transaction(function ($db) use ($model) {
                $model->save();
                return $this->redirectSuccess(['view', 'id' => $model->id], "添加成功");
            });
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新一条已经存在的 DashboardWidget 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // ajax表单验证
        if (($error = $this->ajaxValidation($model)) !== false) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post())) {
            return Yii::$app->db->transaction(function ($db) use ($model) {
                $model->save();
                return $this->redirectSuccess(['view', 'id' => $model->id], "修改成功");
            });
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除一条存在的 DashboardWidget 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete()
    {
        //如果这里不正确，请给表添加一个单一主键Id
        $id = Yii::$app->request->post('id');
        if (!$id) {
            $id = Yii::$app->request->get('id');
        }
        if (is_array($id)) {
            $modelList = DashboardWidget::findAll(['id' => $id]);
            if ($modelList) {
                foreach ($modelList as $model) {
                    Yii::$app->db->transaction(function ($db) use ($model) {
                        $model->delete();
                    });
                }
            }
        } else {
            Yii::$app->db->transaction(function ($db) use ($id) {
                $this->findModel($id)->delete();
            });
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * 渲染小部件的视图
     * @param integer $id
     * @return string
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionRender($id)
    {
        $model = $this->findModel($id);
        $args = Json::decode($model->args);
        return call_user_func([$model->widget, 'widget'], $args);
    }

    /**
     * 根据模型的主键Id查询 DashboardWidget 模型.
     * 如果模型没有找到,  404 HTTP 异常将会抛出.
     * @param integer $id
     * @return DashboardWidget the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel($id)
    {

        if (($model = DashboardWidget::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
