<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use app\kit\helpers\MiscHelper;

/**
 *
 * @author dungang
 *        
 */
class PanelNavTabs extends Widget
{

    public $wrapper = false;

    public $wrapperTag = 'div';

    public $wrapperClass = 'nav-tabs-custom  tab-default';

    public $tabs;
    
    public $tabClass = 'nav nav-tabs';

    public function run()
    {
        if (! is_array($this->tabs))
            return '';
        $this->tabs = MiscHelper::reActiveItem($this->tabs);
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

