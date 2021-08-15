<?php


namespace Addons\Cms\PageBlock\Elements\Image;

use Addons\Cms\PageBlock\BaseBlockWidget;
use yii\helpers\Html;

/**
 * 图片信息
 * Class ImageInfo
 * @package Addons\Cms\PageBlock\Elements\Image
 */
class ImageInfo extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'image-info.png';
    public $codeFile = 'image-info';
//    public function prepareLiveCode()
//    {
//        return Html::img('/images/computer.jpg');
//    }
}