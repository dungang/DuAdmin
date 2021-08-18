<?php

namespace Addons\Cms\PageBlock\Layouts\Bar;

use Addons\Cms\PageBlock\BaseBlockWidget;

class Bar extends BaseBlockWidget
{
    public $type = 'layout';
    public $basePath = __DIR__;
    public $iconFile = 'bar.png';
    public $htmlOptions = [
        'style'=>'height:30px;'
    ];
    public function prepareLiveCode(){
        return '';
    }
}