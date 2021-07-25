<?php


namespace Addons\Cms\PageBlock\LayoutSection;


use yii\base\Widget;

class Icon extends Widget
{
    public function run()
    {
        \Yii::$app->getResponse()->sendFile(__DIR__ . "/section.png");
    }
}