<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\widgets\PjaxAsset;

/**
 * 简单模态框
 * 支持pjax，由于模态框是bootstrap modal.load方法加载，替换的是.modal-content的子内容
 * 所以 pjax必须用.modal-content做容器，否则就出现排版错误
 *
 * @author dungang
 *
 */
class SimpleModal extends Modal
{
    public $debug = false;

    public function run()
    {
        $this->debug = YII_ENV_DEV;
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
        $bool = $this->debug ? 'true' : 'false';
        return <<<JS
(function($, modalSelector) {
    var modal = $(modalSelector);
    var pjaxContainer = null;
    // 清空对象
    modal.on('hidden.bs.modal', function(e) {
        modal.data('bs.modal', null);
        modal.find('.modal-body').empty();
        modal.find('script').remove();
        modal.find('link').remove();
        pjaxContainer = null;
    });
    // 根据属性调整modal窗口大小
    modal.on('show.bs.modal', function(e) {
        var targetBtn = $(e.relatedTarget);
        if(targetBtn.attr('data-toggle') == 'modal') {
            pjaxContainer = targetBtn.parents('[data-pjax-container]');
            if(${bool}) {
                console.log('simple modal debug: pjax container');
                console.log(pjaxContainer);
            }
            var size = targetBtn.data('modal-size');
            $(e.target).find('.modal-dialog').removeClass('modal-sm modal-lg').addClass(size ? size : '');
        }
        
    });
    //阻拦默认的表单提交事件，自动替换为pjax请求
    modal.on('submit','form',function(event){
        event.preventDefault();
        $(event.target).ajaxSubmit({headers:{'AJAX-SUBMIT':'AJAX-SUBMIT'},success:function(data){
            var type = "error";
            if(data.status == 'success'){
                if(pjaxContainer && pjaxContainer.length>0){
                    var pjaxId = pjaxContainer.attr('id');
                    if(${bool}) {
                        console.log('simple modal debug: pjax id');
                        console.log(pjaxId);
                    }
                    if(pjaxId != undefined){
                        $.pjax.reload('#'+pjaxId);
                    }
                } else {
                    window.location.reload(true);
                }
                modal.modal('hide');
                type = "success";
            }
            if(${bool}) {
                console.log('simple modal debug: notify');
                console.log(type);
                console.log(data);
            }
            notif({type:type,msg:data.message,position:'center',timeout:3000});
        }});
    });
})(jQuery, '{$selector}')
JS;
    }
}
