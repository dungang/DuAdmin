<?php

namespace DuAdmin\Components;

use Yii;
use yii\base\Theme;
use yii\i18n\PhpMessageSource;

/**
 * 官方的主题设置
 */
class DUATheme extends Theme
{

    public $name = 'basic';

    public function init()
    {
        parent::init();
        //配置主题的国际化文件的位置
        Yii::$app->i18n->translations['theme'] = [
            'class' => PhpMessageSource::class,
            'sourceLanguage' => Yii::$app->sourceLanguage,
            'basePath' => '@app/themes/' . $this->name . '/messages'
        ];
    }
}
