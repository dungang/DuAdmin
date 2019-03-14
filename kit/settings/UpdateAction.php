<?php
namespace app\kit\settings;

use app\kit\core\UpdateModelAction;

/**
 *
 * @author dungang
 *        
 */
class UpdateAction extends UpdateModelAction
{
    public $settingCategory = 'base';
    public function init(){
        parent::init();
        $this->modelClass = [
            'class'=>'app\kit\models\Setting',
            'category'=>$this->settingCategory
        ];
    }
}

