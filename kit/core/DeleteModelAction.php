<?php

namespace app\kit\core;

class DeleteModelAction extends BaseAction
{

    public $redirect = null;

    public function init()
    {
        if (null === $this->redirect) {
            $this->redirect = \Yii::$app->request->referrer;
        }
    }

    public function run()
    {
        /*@var $model \yii\db\ActiveRecord */
        $model = $this->findModel();
        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        if ($model->delete() === false) {
            return $this->controller->redirectOnFail($this->redirect);
        } else {
            return $this->controller->redirectOnSuccess($this->redirect);
        }
    }
}
