<?php
namespace app\kit\eventhandlers;

use yii\base\ViewEvent;
use yii\web\View;
use app\kit\helpers\KitHelper;

/**
 * 网站页面头部添加统计代码
 *
 * @author dungang
 */
class SiteStatisticCodeHandler extends AbstractEventHandler
{

    /**
     * (non-PHPdoc)
     *
     * @param ViewEvent $event
     * @see \app\kit\eventhandlers\AbstractEventHandler::process()
     */
    public function process($event)
    {
        if ($this->isNotAjaxWithFrontend()) {
            if ($statisticCode = KitHelper::getSetting('site.tongji')) {
                $view = \Yii::$app->view;
                $view->registerJs($statisticCode, View::POS_HEAD);
            }
        }
    }
}
