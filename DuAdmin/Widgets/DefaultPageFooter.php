<?php

namespace DuAdmin\Widgets;

use DuAdmin\Helpers\AppHelper;
use yii\base\Widget;

class DefaultPageFooter extends Widget
{

    public function run()
    {
        return $this->render('page-footer');
    }

    public static function renderPageFooter()
    {
        $className = AppHelper::getSetting('site.pageFooterWidget', DefaultPageFooter::class);
        return call_user_func([$className, 'widget']);
    }
}