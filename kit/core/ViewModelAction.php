<?php
namespace app\kit\core;

class ViewModelAction extends BaseAction
{

    public function run()
    {
        return $this->controller->render($this->viewName, [
            'model' => $this->findModel()
        ]);
    }
}

