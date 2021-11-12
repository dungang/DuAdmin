<?php

namespace DuAdmin\Widgets;

use yii\bootstrap\Html;
use yii\bootstrap\Modal;
use yii\helpers\Json;
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

    /**
     * string js callback(url),return request url
     */
    public $customHandleResult = false;

    /**
     * position
     * 'left', 'center', 'right', 'bottom'
     */
    public $notifyPosition = "center"; 

    public $timeout = 3000;

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
        $options = Json::htmlEncode([
            'debug' => $this->debug,
            'customHandleResult' => $this->customHandleResult,
            'notifyPosition' => $this->notifyPosition,
            'timeout' => $this->timeout
        ]);
        return '$("' . $selector . '").simpleModal(' . $options . ');';
    }
}
