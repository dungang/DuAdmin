<?php


namespace Addons\Cms\PageBlock\Elements\DialogButton;


use Addons\Cms\PageBlock\PlaceHolderWidget;
use DuAdmin\Helpers\AppHelper;

class PlaceHolder extends PlaceHolderWidget
{
    public $type = 'element';

    public function renderBlock()
    {
        return AppHelper::linkButtonWithSmallSimpleModal( '更多了解', AppHelper::createFrontendUrl(['/site/contact-qr']), ['class' => 'btn btn-primary'] );
    }
}