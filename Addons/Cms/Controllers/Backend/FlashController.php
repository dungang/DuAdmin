<?php

namespace Addons\Cms\Controllers\Backend;

use Addons\Cms\Models\Flash;
use Addons\Cms\Models\FlashSearch;
use DuAdmin\Core\BackendController;
use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * Flash 模型的控制器
 * FlashController 实现了常规的增删查改等行为
 */
class FlashController extends BackendController
{

    /**
     * 列出所有的 Flash 模型.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new FlashSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * 显示单个的 Flash 模型数据.
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
     * 创建一个新的 Flash 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Flash();
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
     * 更新一条已经存在的 Flash 模型.
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
     * 删除一条存在的 Flash 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete()
    {
        $id = Yii::$app->request->post("id");
        if (is_array($id)) {
            $modelList = Flash::findAll([
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
     * 根据模型的主键Id查询 Flash 模型.
     * 如果模型没有找到, 404 HTTP 异常将会抛出.
     *
     * @param integer $id
     * @return Flash the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel($id)
    {

        if (($model = Flash::findOne([
            'id' => $id
        ])) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
