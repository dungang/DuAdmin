<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;
use app\kit\assets\EmojiOneAreaAsset;

class EmojiOneArea extends Widget
{

    public function run()
    {
        EmojiOneAreaAsset::register($this->view);
        $this->clientOptions['pickerPosition'] = 'bottom';
        // $this->clientOptions['useInternalCDN']=false;
        $this->registerPlugin('emojioneArea');
    }
}

