<?php

namespace DuAdmin\Hooks;

use yii\web\View;
use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * 网站页面头部添加统计代码
 *
 * @author dungang
 */
class SiteStatisticCodeHandler extends Handler
{
    public function isNotAjaxWithFrontend()
    {
        return \Yii::$app->request->isAjax === false;
    }

    /**
     * (non-PHPdoc)
     *
     * @param \DuAdmin\Core\Hook $hook 
     * @see \DuAdmin\Hooks\Handler::process()
     */
    public function process($hook)
    {
        if ($this->isNotAjaxWithFrontend()) {
            if ($statisticCode = AppHelper::getSetting('site.tongji')) {
                $hook->owner->registerJs($statisticCode, View::POS_HEAD);
            }
        } else {
            Yii::debug('is ajax request');
        }
    }
}
