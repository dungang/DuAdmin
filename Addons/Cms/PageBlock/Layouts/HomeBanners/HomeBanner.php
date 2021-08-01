<?php

namespace Addons\Cms\PageBlock\Layouts\HomeBanners;

use Addons\Cms\PageBlock\BaseBlockWidget;

class HomeBanner extends BaseBlockWidget
{
    public $type = 'layout';
    public $basePath = __DIR__;
    public $cssFile = "home-banner.css";
    public $iconFile = 'home-banner.png';
    public $codeFile = 'home-banner-code';
}