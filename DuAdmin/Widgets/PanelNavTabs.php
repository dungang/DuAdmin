<?php

namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;
use DuAdmin\Helpers\AppHelper;
use Yii;

/**
 * 导航选项卡
 * @author dungang
 *        
 */
class PanelNavTabs extends Widget
{

    /**
     * 是否包装tabs样式
     */
    public $wrapper = false;

    public $wrapperTag = 'div';

    public $wrapperClass = 'nav-tabs-custom  tab-default';

    /**
     * 是否有全部tab
     */
    public $hasAllTab = false;

    /**
     * 选项卡项目
     * @var array
     */
    public $tabs;

    public $tabClass = 'nav nav-tabs';

    public function run()
    {
        if (!is_array($this->tabs)) {
            return '';
        }

        if ($this->hasAllTab) {
            array_unshift($this->tabs, [
                'name' => Yii::t("da", "All"),
                'url'  => [
                    '/' . Yii::$app->controller->uniqueId,
                ]
            ]);
        }
        
        $this->tabs = AppHelper::reActiveItem($this->tabs);
        if ($this->wrapper) {
            return Html::tag($this->wrapperTag, $this->renderTabs(), [
                'class' => $this->wrapperClass
            ]);
        }
        return $this->renderTabs();
    }

    protected function renderTabs()
    {
        $items = '';
        foreach ($this->tabs as $tab) {
            $items .= Html::tag('li', Html::a($tab['name'], $tab['url'], isset($tab['options']) ? $tab['options'] : null), [
                'class' => isset($tab['isActive']) && $tab['isActive'] ? 'active' : null,
                'role' => 'presentation'
            ]);
        }
        return Html::tag('ul', $items, [
            'class' => $this->tabClass
        ]);
    }
}
