<?php
namespace app\kit\core;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\web\Response;
use app\kit\events\CoreEvent;

class CreateModelAction extends BaseAction
{
    const EVENT_CREATE_SUCCESS = 'createSuccess';
    
    public function run()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = \Yii::createObject($this->modelClass);
        $model->load(\Yii::$app->request->queryParams);
        $data = [
            'model' => $model
        ];
        // ajax表单验证
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        // 执行表单提交
        if (($loaded = $model->load(\Yii::$app->request->post())) && $model->save()) {
            
            $this->trigger(self::EVENT_CREATE_SUCCESS,new CoreEvent([
                'payload'=>$model,
            ]));
            if (! $this->successRediretUrl) {
                $this->successRediretUrl = \Yii::$app->request->referrer;
            }
            return $this->controller->redirectOnSuccess($this->getSuccessRediretUrlWidthModel($model), "添加成功");
        }

        if (\Yii::$app->request->isPost) {
            if ($loaded === false) {
                return $this->controller->renderOnFail($this->viewName, $data, '可能表达的字段更服务端不一致');
            }
            return $this->controller->renderOnFail($this->viewName, $data, $model->firstErrors);
        }

        return $this->controller->render($this->viewName, $data);
    }
}

