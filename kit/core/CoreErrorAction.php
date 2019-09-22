<?php

namespace app\kit\core;

use Yii;
use yii\web\ErrorAction;

/**
 * 重写错误处理的action
 * @author dungang<dungang@126.com>
 * date: 2019年9月20日
 */
class CoreErrorAction extends ErrorAction
{
    public function run()
    {
        if ($this->layout !== null) {
            $this->controller->layout = $this->layout;
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            Yii::$app->getResponse()->setStatusCode(200);
        } else {
            Yii::$app->getResponse()->setStatusCodeByException($this->exception);
        }
        return $this->renderHtmlResponse();
    }
}