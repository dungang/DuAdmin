<?php
namespace app\kit\core;

use Yii;

class UpdateModelsAction extends BaseAction
{

    public function run($id)
    {
        /* @var $model \yii\db\ActiveRecord */
        /* @var $models \yii\db\ActiveRecord[] */
        $ids = explode(',', $id);
        $models = $this->findModels($ids);
        $data = [
            'models' => $models
        ];
        try {
            Yii::$app->db->transaction(
                function ($db) use ($models) {
                    foreach ($models as $model) {
                        // 动态绑定行为
                        $model->attachBehaviors($this->modelBehaviors);
                        $model->load($this->composePostParams($model)) && $model->save(false);
                    }
                    return $this->controller->redirectOnSuccess(\Yii::$app->request->referrer, "修改成功");
                });
        } catch (\Exception $e) {
            Yii::warning($e->getTraceAsString());
            return $this->controller->renderOnException($this->viewName, $data);
        }

        return $this->controller->renderOnSuccess($this->viewName, $data);
    }
}

