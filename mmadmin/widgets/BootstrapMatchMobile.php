<?php
namespace app\mmadmin\widgets;

use yii\base\Widget;
use app\mmadmin\helpers\MAHelper;

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

