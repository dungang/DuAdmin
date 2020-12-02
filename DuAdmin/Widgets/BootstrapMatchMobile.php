<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use DuAdmin\Helpers\MAHelper;

/**
 *
 * @author dungang
 */
class BootstrapMatchMobile extends Widget
{

    public $container = '.container';

    public function run()
    {
        if(MAHelper::IsMobile()){
            $this->view->registerJs(
                "$(function(){
                $('{$this->container}').width($('{$this->container}').width()-30);
        });");
        }
    }
}

