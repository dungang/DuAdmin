<?php

namespace DuAdmin\Widgets;

use Yii;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\InputWidget;

/**
 * 验证码发送计时小部件
 */
class CaptchaSend extends InputWidget
{

    public $targetField = 'mobile';

    public $sendRoute;

    public $counterDownSeconds  = 60;

    public function run()
    {
        return $this->renderSendInput();
    }

    public function renderSendInput()
    {

        $this->view->registerJs($this->bindJs(), View::POS_READY, 'captcha-send-btn');
        $input = $this->renderInputHtml("text");
        $idInfo = explode('-', $this->options['id']);
        $idInfo[1] = $this->targetField;
        $targetIdInfo = implode('-', $idInfo);
        $btnTxt = Yii::t('da', 'Send');
        $url = Url::to($this->sendRoute);
        return <<<INPUT
<div class="input-group">
    $input 
    <span class="input-group-btn">
        <button class="btn btn-default captcha-send-btn" type="button"  autocomplete="off" data-target="#$targetIdInfo" data-url="$url" data-text="$btnTxt">$btnTxt</button>
    </span>
</div>
INPUT;
    }

    public function bindJs()
    {
        return <<<JS
        $('.captcha-send-btn').click(function(){
            var btn = $(this);
            var btnData = btn.data();
            var val = $(btnData.target).val();
            if(val != "" || val.length > 0) {
                btn.attr('disabled', 'disabled');
                $.post(btnData.url,{
                    receiver: $(btnData.target).val()
                })
                .done(function(data){
                    var second = $this->counterDownSeconds;
                    var timer = setInterval(() => {
                        if(second == -1) {
                            btn.text(btnData.text);
                            btn.removeAttr("disabled");
                            clearInterval(timer);
                            return ;
                        }
                        btn.text(second+"s");
                        second -=1;
                    }, 1000);
                })
                .fail(function(xhr,textStatus,error){
                    $.showLayerMsg(xhr.responseJSON.message,2,3000);
                    btn.removeAttr('disabled')
                })
            } else {
                $.showLayerMsg("$this->targetField 不能为空",2,3000);
            }
            
        })
JS;
    }
}
