<?php
namespace Addons\Cms\PageBlock\Elements\Image;

use Addons\Cms\PageBlock\BaseBlockWidget;
use yii\helpers\Html;

class Image extends BaseBlockWidget
{
    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'image.png';
    public $htmlOptions = [
        'class' => 'image-scale-box'
    ];
    public function prepareLiveCode()
    {
        return Html::img('/images/computer.jpg');
    }
}