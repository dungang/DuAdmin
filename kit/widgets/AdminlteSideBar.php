<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;

/**
 * adminlte侧边导航菜单
 * @author dungang
 *
 */
class AdminlteSideBar extends Widget
{
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
        //注册js代码最好结束的时候加上语句结束表示`;`分号，
        //否则会出现语法错误，比如下面就会提示pushMenu方法未定义
        $this->view->registerJs("$('[data-toggle=\"push-menu\"]').pushMenu();");
        $content =  ob_get_clean();
        $start = '<aside class="main-sidebar"><section class="sidebar">';
        $end = '</section></aside>';
        return $start  . $content  .$end;
    }
}

