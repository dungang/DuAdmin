<?php

namespace DuAdmin\Core;

use Yii;
use yii\base\Model;

class CreateModelsAction extends BaseAction
{

    public $formName;

    public function run()
    {
        $data = Yii::$app->request->post($this->formName, []);
        $count = count(Yii::$app->request->post($this->formName, []));
        /* @var $model \yii\db\ActiveRecord */
        /* @var $models \yii\db\ActiveRecord[] */
        $model = Yii::createObject($this->modelClass);
        $model->load(Yii::$app->request->queryParams);
        $models = [
            $model
        ];
        $this->data = [
            'models' => $models
        ];
        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        for ($i = 1; $i < $count; $i++) {
            $model = Yii::createObject($this->modelClass);
            $model->load(Yii::$app->request->queryParams);
            // 动态绑定行为
            $model->attachBehaviors($this->modelBehaviors);
            $models[] = $model;
        }
        if ($this->isPost()) {
            if (($loaded = Model::loadMultiple($models, $this->composePostParams($model, true)))
                && Model::validateMultiple($models)
            ) {
                Yii::$app->db->transaction(function ($db) use ($models) {
                    foreach ($models as $model) {
                        $model->save(false);
                    }
                });
                return $this->controller->redirectOnSuccess(Yii::$app->request->referrer, $this->successMsg);
            }

            if ($loaded === false) {
                $this->beforeRender();
                return $this->controller->renderOnFail($this->viewName, $this->data, Yii::t('da', 'Data fields error'));
            }
            foreach($models as $model) {
                if ($model->hasErrors()) {
                    return $this->controller->renderOnFail($this->viewName, $this->data, array_values($model->getFirstErrors())[0]);
                }
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}