<?php
namespace app\kit\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;

/**
 * 模型保存之后执行的回调
 * @author dungang
 */
class AfterSaveBehavior extends Behavior
{
    public $callback;
    
    public function events(){
        return [
            ActiveRecord::EVENT_AFTER_INSERT =>'afterSave',
            ActiveRecord::EVENT_AFTER_UPDATE =>'afterSave',
        ];
    }
    
    public function afterSave($event){
        \call_user_func($this->callback,$this->owner);
    }
}

