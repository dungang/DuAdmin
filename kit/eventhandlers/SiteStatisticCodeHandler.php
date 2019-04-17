<?php
namespace app\kit\eventhandlers;

use yii\base\ViewEvent;
use yii\web\View;
use app\kit\core\FrontendController;
use app\kit\helpers\KitHelper;

/**
 * 网站页面头部添加统计代码
 *
 * @author dungang
 */
class SiteStatisticCodeHandler extends EventHandler
{

    /**
     * (non-PHPdoc)
     *
     * @param ViewEvent $event
     * @see \app\kit\eventhandlers\EventHandler::process()
     */
    public function process($event)
    {
        if (\Yii::$app->controller instanceof FrontendController) {
            if ($statisticCode = KitHelper::getSetting('site.tongji')) {
                $view = \Yii::$app->view;
                $view->registerJs($statisticCode, View::POS_HEAD);
            }
        }
    }
}

