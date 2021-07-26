<?php

namespace Addons\Cms\PageBlock\Layouts\LeftFullImageSection;

use yii\base\Widget;

class Asset extends Widget
{
    public function run()
    {
        return $this->css();
    }

    public function css()
    {
        return <<<CSS
<style>
    .element-section .col-md-6 {
        height: 200px;
    }
    .element-section .img-holder{
        background-position: center;
        background-size: cover;
        background-repeat: no-repeat;
        height: 100%;
    }
    .element-section-info {
        padding: 30px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        text-align:left;
    }
    /* 小屏幕（平板，大于等于 768px） */
    @media (min-width: 768px) {
        .element-section .col-md-6 {
            height: 250px;
        }
    }

    /* 中等屏幕（桌面显示器，大于等于 992px） */
    @media (min-width: 992px) {
        .element-section .col-md-6  {
            height: 300px;
        }
    }

    /* 大屏幕（大桌面显示器，大于等于 1200px） */
    @media (min-width: 1200px) {
        .element-section .col-md-6  {
            height: 400px;
        }
    }
</style>
CSS;
    }
}