<?php


namespace Addons\Cms\PageBlock\ElementDialogButton;


use DuAdmin\Helpers\AppHelper;
use yii\helpers\Html;

class PlaceHolder extends \yii\base\Widget
{
    public function run()
    {
        return AppHelper::linkButtonWithSimpleModal( '更多了解', AppHelper::createFrontendUrl(['/site/contact-qr']), ['class' => 'du-live-element btn btn-primary'] );
    }
}