<?php
namespace app\mmadmin\widgets;

use yii\base\Widget;
use app\mmadmin\helpers\KitHelper;

/**
 *
 * @author dungang
 */
class BootstrapMatchMobile extends Widget
{

    public $container = '.container';

    public function run()
    {
        if(KitHelper::IsMobile()){
            $this->view->registerJs(
                "$(function(){
                $('{$this->container}').width($('{$this->container}').width()-30);
        });");
        }
    }
}

