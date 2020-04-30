<?php

namespace app\kit\core;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Response;

class UpdateModelAction extends BaseAction
{

    public $createOneOnNotFound = false;

    public function run()
    {

        /* @var $model \yii\db\ActiveRecord */
        $model = $this->findModel($this->createOneOnNotFound);

        $model->getPrimaryKey();
        $model->load(\Yii::$app->request->queryParams);
        $this->data = [
            'model' => $model
        ];

        // ajax表单验证
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        if ($this->isPost()) {
            if (($loaded = $model->load($this->composePostParams($model))) && $model->save()) {
                if (!$this->successRediretUrl) {
                    $this->successRediretUrl = \Yii::$app->request->referrer;
                }
                return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), "修改成功");
            }

            if ($loaded === false) {
                return $this->controller->renderOnFail($this->viewName, $this->data, '可能表达的字段更服务端不一致');
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}
