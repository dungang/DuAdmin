<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\Modal;
use yii\bootstrap\Html;
use yii\widgets\PjaxAsset;

class SimpleModal extends Modal
{
    
    public $enablePjax = true;

    public function run()
    {
        echo "\n" . $this->renderBodyEnd();
        echo "\n" . $this->renderFooter();
        echo "\n" . Html::endTag('div'); // modal-content
        echo "\n" . Html::endTag('div'); // modal-dialog
        echo "\n" . Html::endTag('div');
        PjaxAsset::register($this->view);
        $this->view->registerjs($this->getJs('#' . $this->options['id']));
    }

    public function getJs($selector)
    {
        return <<<JS
(function($, modalSelector) {

    var modal = $(modalSelector);
    // 清空对象
    modal.on('hidden.bs.modal', function(e) {    
        $(e.target).data('bs.modal', null);
    });
    // 根据属性调整modal窗口大小
    modal.on('show.bs.modal', function(e) {
        var size = $(e.relatedTarget).data('modal-size');
        $(e.target).find('.modal-dialog').removeClass('modal-sm modal-lg').addClass(size ? size : '');
    });
    //阻拦默认的表单提交事件，自动替换为pjax请求
    if({$this->enablePjax}){
        modal.on('submit','form',function(event){
            event.preventDefault();
            console.log($(this));
            $.pjax.submit(event,'.modal-content',{push:false});
        });
    }
})(jQuery, '{$selector}')
JS;
    }
}
