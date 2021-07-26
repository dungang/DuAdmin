<?php


namespace Addons\Cms\PageBlock\Layouts\LeftFullImageSection;


use yii\base\Widget;

class Icon extends Widget
{
    public function run()
    {
        \Yii::$app->getResponse()->sendFile( __DIR__ . "/icon.png" );
    }
}