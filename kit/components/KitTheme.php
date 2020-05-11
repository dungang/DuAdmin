<?php

namespace app\kit\components;

use Yii;
use yii\base\Theme;
use yii\i18n\PhpMessageSource;

class KitTheme extends Theme
{

    public $name = 'basic';

    public function init()
    {
        parent::init();
        Yii::$app->i18n->translations['theme'] = [
            'class' => PhpMessageSource::className(),
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => '@app/themes/' . $this->name . '/messages'
        ];
    }
}
