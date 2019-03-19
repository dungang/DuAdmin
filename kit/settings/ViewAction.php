<?php
namespace app\kit\settings;

use app\kit\core\ViewModelAction;

/** 
 * @author dungang
 * 
 */
class ViewAction extends ViewModelAction
{
    public $settingCategory = 'base';
    
    public function init()
    {
        parent::init();
        $this->modelClass = [
            'class' => 'app\kit\models\Setting',
            'category' => $this->settingCategory
        ];
    }
}

