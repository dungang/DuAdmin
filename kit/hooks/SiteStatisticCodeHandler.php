<?php

namespace app\kit\hooks;

use app\kit\core\FrontendController;
use yii\web\View;
use app\kit\helpers\KitHelper;

/**
 * 网站页面头部添加统计代码
 *
 * @author dungang
 */
class SiteStatisticCodeHandler extends Handler
{
    public function isNotAjaxWithFrontend()
    {
        return !\Yii::$app->request->isAjax && (\Yii::$app->controller instanceof FrontendController);
    }

    /**
     * (non-PHPdoc)
     *
     * @param \app\kit\core\Hook $hook 
     * @see \app\kit\hooks\Handler::process()
     */
    public function process($hook)
    {
        if ($this->isNotAjaxWithFrontend()) {
            if ($statisticCode = KitHelper::getSetting('site.tongji')) {
                $view = \Yii::$app->view;
                $view->registerJs($statisticCode, View::POS_HEAD);
            }
        }
    }
}
