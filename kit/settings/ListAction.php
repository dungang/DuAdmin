<?php
namespace app\kit\settings;

use app\kit\core\ListModelsAction;

/**
 *
 * @author dungang
 *        
 */
class ListAction extends ListModelsAction
{

    public $settingCategory = 'base';

    public function init()
    {
        parent::init();
        $this->modelClass = [
            'class' => '\app\kit\models\SettingSearch',
            'category' => $this->settingCategory
        ];
    }
}

