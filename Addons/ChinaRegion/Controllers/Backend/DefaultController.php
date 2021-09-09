<?php

namespace Addons\ChinaRegion\Controllers\Backend;

use Yii;
use yii\web\NotFoundHttpException;
use Addons\ChinaRegion\Models\ChinaRegion;
use Addons\ChinaRegion\Models\ChinaRegionSearch;
use DuAdmin\Core\BackendController;

/**
 * ChinaRegion 模型的控制器
 * DefaultController 实现了常规的增删查改等行为
 */
class DefaultController extends BackendController
{
    /**
     * 请求action 方法设置
     * @var array
     */
     public $verbsActions = ['delete' => ['POST']];
    /**
     * 列出所有的 ChinaRegion 模型.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChinaRegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个的 ChinaRegion 模型数据.
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
     * 创建一个新的 ChinaRegion 模型.
     * 如果创建成果,浏览器将会跳转的到该模型的详情视图界面.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChinaRegion();

        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectSuccess(['view', 'id' => $model->id], "添加成功");
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新一条已经存在的 ChinaRegion 模型.
     * 如果更新成果,浏览器将会跳转的到该模型的详情视图界面.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        // ajax表单验证
        if ( ($error = $this->ajaxValidation( $model )) !== false ) {
            return $error;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirectSuccess(['view', 'id' => $model->id], "修改成功");
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * 删除一条存在的 ChinaRegion 模型.
     * 如果删除成果,浏览器将会跳转的到该模型的列表视图界面.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException 如果模型没查询到
     */
    public function actionDelete($id)
    {
    	if( is_array($id) ) {
    		$modelList = ChinaRegion::findAll(['id' => $id]);
    		if( $modelList ) {
    			foreach($modelList as $model) {
    				$model->delete();
    			}
    		}
    	} else {
        	$this->findModel($id)->delete();
    	}
        return $this->redirect(['index']);
    }

    /**
     * 根据模型的主键Id查询 ChinaRegion 模型.
     * 如果模型没有找到,  404 HTTP 异常将会抛出.
     * @param integer $id
     * @return ChinaRegion the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel($id)
    {

        if (($model = ChinaRegion::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
