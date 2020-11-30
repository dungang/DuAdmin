<?php

namespace app\mmadmin\core;

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
        $model->load(\Yii::$app->request->queryParams);

        $this->data = [
            'model' => $model
        ];

        // ajax表单验证
        if ($this->isAjaxNotPjax() && $model->load(Yii::$app->request->post())) {
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
                $this->beforeRender();
                return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), Yii::t('ma', 'Update success'));
            }

            if ($loaded === false) {
                return $this->controller->renderOnFail($this->viewName, $this->data, Yii::t('ma', 'Data fields error'));
            } else if ($model->hasErrors()) {
                return $this->controller->renderOnFail($this->viewName, $this->data, array_values($model->getFirstErrors())[0]);
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}
