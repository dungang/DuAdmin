<?php

namespace DuAdmin\Api;

class DeleteAction extends BaseAction
{
    public $newOneOnNotFound = false;
    
    public function run()
    {
      /*@var $model \yii\db\ActiveRecord */
      $model = $this->findModel();
      // 动态绑定行为
      $model->attachBehaviors($this->modelBehaviors);
      return $model->delete();
    }
}