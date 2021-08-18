<?php


namespace Addons\Cms\PageBlock\Elements\Lists;


use Addons\Cms\PageBlock\BaseBlockWidget;

/**
 * 最新上传文档
 * Class ListNewest
 * @package Addons\Doc\PageBlock\Elements\Lists
 */
class ListNewest extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'list-newest.png';
    public $codeFile = 'list3-code';
    public $isDynamic = true;
    public $params = ['size' => 10];
}