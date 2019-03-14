<?php
namespace app\kit\settings;

use app\kit\core\CreateModelAction;

/**
 *
 * @author dungang
 *        
 */
class CreateAction extends CreateModelAction
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

