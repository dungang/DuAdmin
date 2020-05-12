<?php

namespace app\mmadmin\hooks;

use app\mmadmin\core\FrontendController;
use yii\web\View;
use app\mmadmin\helpers\MAHelper;

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
     * @param \app\mmadmin\core\Hook $hook 
     * @see \app\mmadmin\hooks\Handler::process()
     */
    public function process($hook)
    {
        if ($this->isNotAjaxWithFrontend()) {
            if ($statisticCode = MAHelper::getSetting('site.tongji')) {
                $view = \Yii::$app->view;
                $view->registerJs($statisticCode, View::POS_HEAD);
            }
        }
    }
}
