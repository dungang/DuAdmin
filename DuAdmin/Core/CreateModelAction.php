<?php

namespace DuAdmin\Core;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use DuAdmin\Events\CustomerEvent;

class CreateModelAction extends BaseAction
{

    const EVENT_CREATE_SUCCESS = 'createSuccess';

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = \Yii::createObject($this->modelClass);
        $model->load(\Yii::$app->request->queryParams);

        $model->setAttributes($this->baseAttrs);
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

        // 执行表单提交
        if ($this->isPost()) {
            if (($loaded = $model->load($this->composePostParams($model))) && $model->save()) {

                $this->trigger(self::EVENT_CREATE_SUCCESS, new CustomerEvent([
                    'payload' => $model
                ]));

                if (!$this->successRediretUrl) {
                    $this->successRediretUrl = \Yii::$app->request->referrer;
                }
                return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), $this->successMsg);
            }

            if ($loaded === false) {
                $this->beforeRender();
                return $this->controller->renderOnFail($this->viewName, $this->data,  Yii::t('ma', 'Data fields error'));
            } else if ($model->hasErrors()) {
                return $this->controller->renderOnFail($this->viewName, $this->data, array_values($model->getFirstErrors())[0]);
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}
