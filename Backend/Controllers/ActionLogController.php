<?php

namespace Backend\Controllers;

use Yii;
use Backend\Models\ActionLog;
use Backend\Models\ActionLogSearch;
use DuAdmin\Core\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use DuAdmin\Helpers\AppHelper;

/**
 * ActionLog 模型的控制器
 * ActionLogController 实现了常规的增删查改等行为 
 */
class ActionLogController extends BackendController
{

    /**
     * 列出所有的 ActionLog 模型.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ActionLogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * 显示单个的 ActionLog 模型数据.
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
     * 根据模型的主键Id查询 ActionLog 模型.
     * 如果模型没有找到,  404 HTTP 异常将会抛出.
     * @param integer $id
     * @return ActionLog the loaded model
     * @throws NotFoundHttpException 如果模型没查询到
     */
    protected function findModel($id)
    {
        if (($model = ActionLog::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
