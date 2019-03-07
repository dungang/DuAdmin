<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;
use yii\bootstrap\Html;

/**
 * adminlte侧边导航菜单
 * @author dungang
 *
 */
class AdminlteSideBar extends Widget
{
    public $headerLabel = 'MAIN NAVIGATION';
    
    public $items;
    
    public function init()
    {
        parent::init();
        if (! isset($this->options['id'])) {
            $this->options['id'] = $this->getId();
        }
        ob_start();
        ob_implicit_flush(false);
    }
    
    public function run(){
        $this->view->registerJs("$('[data-toggle=\"push-menu\"]').pushMenu()");
        $content =  ob_get_clean();
        $start = '<aside class="main-sidebar"><section class="sidebar">';
        $startMenu = '<ul class="sidebar-menu" data-widget="tree">' . Html::tag('li',$this->headerLabel,['class'=>'header']);
        $endMenu = '</ul>';
        $end = '</aside></section>';
        return $start  . $content . $startMenu . $endMenu .$end;
    }
}

