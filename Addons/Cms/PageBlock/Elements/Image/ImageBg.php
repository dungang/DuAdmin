<?php
namespace Addons\Cms\PageBlock\Elements\Image;

use Addons\Cms\PageBlock\BaseBlockWidget;

class ImageBg extends BaseBlockWidget
{

    public $type = 'element';
    public $basePath = __DIR__;
    public $iconFile = 'image.png';
    public $htmlOptions = [
        'class' => 'img-holder',
        'style' => "background-image: url('/images/computer.jpg')"
    ];

    //<div class="du-live-element img-holder" style="background-image: url('/images/computer.jpg')"></div>
    public function prepareLiveCode()
    {
        return '';
    }
}