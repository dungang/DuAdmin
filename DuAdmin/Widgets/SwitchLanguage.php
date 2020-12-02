<?php

namespace DuAdmin\Widgets;

use DuAdmin\Helpers\AppHelper;
use Yii;
use yii\bootstrap\Widget;
use yii\helpers\Html;

class SwitchLanguage extends Widget
{

    public $wrapper_begin = '<ul class="navbar-nav nav"><li>';

    public $wrapper_end = '</li></ul>';

    public $gap = '</li><li>';

    public $langs;

    public $route;

    public function run()
    {
        if (empty($this->lang)) {
            $this->langs = AppHelper::getSettingAssoc('site.i18n');
        }
        $current_lang = Yii::$app->language;
        if(!$this->route) {
            $current_route = Yii::$app->controller->route;
            $links = [];
            $params = Yii::$app->request->queryParams;
            array_unshift($params, $current_route);
            $this->route = $params;
        }

        foreach ($this->langs as $lang => $name) {
            $this->route['_lang'] = $lang;
            if ($lang == $current_lang) {
                $links[] = Html::a($name, $this->route, ['class' => 'switch-lang-link lang-active']);
            } else {
                $links[] = Html::a($name, $this->route, ['class' => 'switch-lang-link']);
            }
        }
        return $this->wrapper_begin . implode($this->gap, $links)  . $this->wrapper_end;
    }
}
