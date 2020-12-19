<?php
namespace DuAdmin\Core;

class SortableAction extends BaseAction
{
    
    public function run(){
        
        $sorts = \Yii::$app->request->post('sorts');
        if($sorts) {
            return $sorts;
        }
    }
}

