<?php
namespace DuAdmin\Core;

use Yii;
use yii\base\Model;
use DuAdmin\Helpers\AppHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class CreateModelsAction extends BaseAction
{

    public function run()
    {
        $models = $this->discoverModels();
        if ($this->isPost()) {
            $loaded = Model::loadMultiple($models, $this->composePostParams($models[0], true));
            // ajax表单验证
            if (AppHelper::isAjaxValidationRequest()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return call_user_func_array([
                    ActiveForm::class,
                    'validate'
                ], $models);
            }

            if ($loaded && Model::validateMultiple($models)) {
                Yii::$app->db->transaction(function ($db) use ($models) {
                    foreach ($models as $model) {
                        // 动态绑定行为
                        $model->attachBehaviors($this->modelBehaviors);
                        $model->save(false);
                    }
                });
                return $this->controller->redirectOnSuccess(Yii::$app->request->referrer, $this->successMsg);
            }

            if ($loaded === false) {
                $this->beforeRender();
                return $this->controller->renderOnFail($this->viewName, $this->data, Yii::t('da', 'Data fields error'));
            }
            foreach ($models as $model) {
                if ($model->hasErrors()) {
                    return $this->controller->renderOnFail($this->viewName, $this->data, array_values($model->getFirstErrors())[0]);
                }
            }
            return $this->controller->renderOnFail($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }

    public function discoverFormName()
    {
        if (is_array($this->modelClass)) {
            $className = $this->modelClass['class'];
        } else {
            $className = $this->modelClass;
        }
        $pieces = explode('\\', $className);
        return array_pop($pieces);
    }

    public function discoverModels()
    {
        $formName = $this->discoverFormName();
        $count = count(Yii::$app->request->post($formName, []));
        if ($count === 0) {
            $count = 1;
        }
        /* @var $model \yii\db\ActiveRecord */
        /* @var $models \yii\db\ActiveRecord[] */
        $models = [];
        for ($i = 0; $i < $count; $i ++) {
            $model = Yii::createObject($this->modelClass);
            $model->load(Yii::$app->request->queryParams);
            $models[] = $model;
        }
        $this->data = [
            'models' => $models
        ];
        return $models;
    }
}
