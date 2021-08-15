<?php


namespace Addons\Cms\PageBlock\Elements\Base;


use Addons\Cms\PageBlock\BaseBlockWidget;

class Button extends BaseBlockWidget
{
    public $tag = 'button';
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'button.png';

    public $htmlOptions = [
        'class' => 'btn btn-primary',
    ];

    public function prepareLiveCode()
    {
        return '按钮';
    }
}