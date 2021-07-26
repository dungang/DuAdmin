<?php


namespace Addons\Cms\PageBlock\Elements\DialogButton;


class Icon extends \yii\base\Widget
{
    public function run()
    {
        \Yii::$app->getResponse()->sendFile( __DIR__ . "/icon.png" );
    }

}