<?php


namespace Addons\Cms\PageBlock\ElementDialogButton;


class Icon extends \yii\base\Widget
{
    public function run()
    {
        \Yii::$app->getResponse()->sendFile(__DIR__ . "/dialog-button.png");
    }

}