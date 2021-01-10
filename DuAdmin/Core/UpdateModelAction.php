<?php

namespace DuAdmin\Core;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use DuAdmin\Helpers\AppHelper;

class UpdateModelAction extends BaseAction
{

    public $newOneOnNotFound = false;

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = $this->findModel($this->newOneOnNotFound);
        $model->load(\Yii::$app->request->queryParams);

        $this->data = [
            'model' => $model
        ];

        // ajax表单验证
        if (AppHelper::isAjaxValidationRequest() && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }

        if ($this->isPost()) {
            var_dump($model->toArray());
            // 动态绑定行为
            $model->attachBehaviors($this->modelBehaviors);
            if (($loaded = $model->load($this->composePostParams($model))) && $model->save()) {
                if (!$this->successRediretUrl) {
                    $this->successRediretUrl = \Yii::$app->request->referrer;
                }
                $this->beforeRender();
                return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), Yii::t('da', 'Update success'));
            }

            if ($loaded === false) {
                return $this->controller->renderOnFail($this->viewName, $this->data, Yii::t('da', 'Data fields error'));
            } else if ($model->hasErrors()) {
                return $this->controller->renderOnFail($this->viewName, $this->data, array_values($model->getFirstErrors())[0]);
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}