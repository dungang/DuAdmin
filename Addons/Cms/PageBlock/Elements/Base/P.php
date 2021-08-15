<?php


namespace Addons\Cms\PageBlock\Elements\Base;


use Addons\Cms\PageBlock\BaseBlockWidget;

class P extends BaseBlockWidget
{
    public $tag = 'p';
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'p.png';

    public function prepareLiveCode()
    {
        return '段落';
    }
}