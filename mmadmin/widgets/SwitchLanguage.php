<?php

namespace app\mmadmin\widgets;

use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class SwitchLanguage extends Widget
{

    public $wrapper_begin = '<ul class="navbar-nav nav"><li>';
    public $wrapper_end = '</li></ul>';
    public $gap = '</li><li>';

    public $langs = [
        'zh-CN' => '中文',
        'en-US' => 'English',
    ];

    public function run()
    {
        $current_lang = Yii::$app->language;
        $current_route = Yii::$app->controller->route;
        $links = [];
        $params = Yii::$app->request->queryParams;
        array_unshift($params, $current_route);

        foreach ($this->langs as $lang => $name) {
            $params['lang'] = $lang;
            if ($lang == $current_lang) {
                $links[] = Html::a($name, $params, ['class' => 'switch-lang-link lang-active']);
            } else {
                $links[] = Html::a($name, $params, ['class' => 'switch-lang-link']);
            }
        }
        return $this->wrapper_begin . implode($this->gap, $links)  . $this->wrapper_end;
    }
}