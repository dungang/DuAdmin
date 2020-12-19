<?php
namespace DuAdmin\Core;

use yii\helpers\ArrayHelper;

class SortableListAction extends BaseAction
{

    public function run()
    {
        $model = \Yii::createObject($this->modelClass);
        $model->load(\Yii::$app->request->get());
        list ($modelClass, $condition) = $this->builderFindModelCondition($model->attributes);
        $models = $modelClass::find()->where($condition)
            ->asArray()
            ->orderBy('sort')
            ->all();
        return $this->controller->render($this->id, [
            'models' => $models,
            'model' => $model
        ]);
    }
}

;