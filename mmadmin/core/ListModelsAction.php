<?php

namespace app\mmadmin\core;

class ListModelsAction extends BaseAction
{

    /**
     * 如果模型有标记删除的属性，
     * 默认只显示没有删除的数据
     */
    public $query_only_undel = true;

    public function run()
    {
        $searchModel = \Yii::createObject($this->modelClass);
    
        if ($searchModel->hasProperty("is_del") && $this->query_only_undel) {
            $searchModel->is_del = 0;
        }
        // 动态绑定行为
        $searchModel->attachBehaviors($this->modelBehaviors);
        $dataProvider = $searchModel->search($this->composeGetParams($searchModel));
        $this->data = [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider
        ];
        $this->beforeRender();
        return $this->controller->render($this->viewName, $this->data);
    }
}
