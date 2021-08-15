<?php


namespace Addons\Cms\PageBlock\Elements\Base;


use Addons\Cms\PageBlock\BaseBlockWidget;

class H1 extends BaseBlockWidget
{
    public $tag = 'h1';
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'h1.png';

    public function prepareLiveCode()
    {
        return '标题1';
    }
}