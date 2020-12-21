<?php
namespace DuAdmin\Core;

use Yii;
use yii\base\Model;
use DuAdmin\Helpers\AppHelper;
use yii\web\Response;
use yii\widgets\ActiveForm;

class UpdateModelsAction extends BaseAction
{

    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        /* @var $models \yii\db\ActiveRecord[] */
        $models = $this->findModels();
        $this->data = [
            'models' => $models
        ];
        $loaded = Model::loadMultiple($models, $this->composePostParams($models[0], true));
        try {
            // ajax表单验证
            if (AppHelper::isAjaxValidationRequest()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return call_user_func_array([
                    ActiveForm::class,
                    'validate'
                ], $models);
            }

            if ($loaded && Model::validateMultiple($models)) {
                return Yii::$app->db->transaction(function ($db) use ($models) {
                    foreach ($models as $i => $model) {
                        // 动态绑定行为
                        $model->attachBehaviors($this->modelBehaviors);
                        $model->save(false);
                    }
                    if (! $this->successRediretUrl) {
                        $this->successRediretUrl = \Yii::$app->request->referrer;
                    }
                    $this->beforeRender();
                    return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), Yii::t('da', 'Update success'));
                    // return $this->controller->redirectOnSuccess(\Yii::$app->request->referrer, "修改成功");
                });
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
        } catch (\Exception $e) {
            Yii::error($e->getTraceAsString());
            return $this->controller->renderOnException($this->viewName, $this->data);
        }

        return $this->controller->render($this->viewName, $this->data);
    }
}
