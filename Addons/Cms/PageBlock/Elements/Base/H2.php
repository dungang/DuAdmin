<?php


namespace Addons\Cms\PageBlock\Elements\Base;


use Addons\Cms\PageBlock\BaseBlockWidget;

class H2 extends BaseBlockWidget
{
    public $tag = 'h2';
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'h2.png';

    public function prepareLiveCode()
    {
        return '标题2';
    }
}