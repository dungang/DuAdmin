<?php

namespace app\kit\core;

class ListModelsAction extends BaseAction {

    public function run() {
        $searchModel = \Yii::createObject($this->modelClass);
        // 动态绑定行为
        $searchModel->attachBehaviors($this->modelBehaviors);
        $dataProvider = $searchModel->search($this->composeGetParams($searchModel));
        return $this->controller->render($this->viewName, [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
        ]);
    }

}
