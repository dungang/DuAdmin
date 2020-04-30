<?php
namespace app\kit\core;

class ViewModelAction extends BaseAction
{

    public function run()
    {
        $model = $this->findModel();
        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        $model->trigger('afterView');
        $this->data['model'] = $model;
        return $this->controller->render($this->viewName, $this->data);
    }
}

