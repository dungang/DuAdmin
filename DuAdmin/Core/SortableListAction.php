<?php
namespace DuAdmin\Core;

class SortableListAction extends BaseAction
{
    
    public function run(){
        $models = $this->findModels();
        return $this->controller->render($this->id,['models'=>$models]);
    }
}

