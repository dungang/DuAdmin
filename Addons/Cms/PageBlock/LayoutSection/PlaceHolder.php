<?php


namespace Addons\Cms\PageBlock\LayoutSection;


class PlaceHolder extends \yii\base\Widget
{

    public function run()
    {
        return $this->render('place-holder');
    }
}