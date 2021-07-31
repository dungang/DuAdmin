<?php


namespace Addons\Cms\PageBlock\Layouts\Container;


use Addons\Cms\PageBlock\BaseBlockWidget;
use yii\helpers\Html;

/**
 * bootstrap container
 * Class PlaceHolder
 * @package Addons\Cms\PageBlock\LayoutContainer
 */
class Container extends BaseBlockWidget
{
    public $type = 'layout';
    public $basePath = __DIR__;
    public $iconFile = 'container.png';
    public $codeFile = 'container-code';

}