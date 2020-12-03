<?php

namespace DuAdmin\Core;

class ViewModelAction extends BaseAction
{
    public $newOneOnNotFound = false;
    
    public function run()
    {
        $model = $this->findModel($this->newOneOnNotFound);
        // 动态绑定行为
        $model->attachBehaviors($this->modelBehaviors);
        $model->trigger('afterView');
        $this->data['model'] = $model;
        $this->beforeRender();
        return $this->controller->render($this->viewName, $this->data);
    }
}
