<?php
namespace app\kit\settings;

use app\kit\core\DeleteModelAction;

/** 
 * @author dungang
 * 
 */
class DeleteAction extends DeleteModelAction
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

