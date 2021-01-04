<?php
namespace DuAdmin\Grids;

use yii\helpers\Html;

/**
 * 包装一个adminlte panel
 *
 * @author dungang
 *        
 */
class PanelGridView extends GridView
{

    /**
     * 面板标题
     *
     * @var string
     */
    public $title = '功能说明';

    /**
     * 面板介绍
     *
     * @var string|array
     */
    public $intro;

    public $panelClass = 'panel panel-adminlte grid-view';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body clearfix';

    private $_toolBody = '';

    public $layout = "{items}\n{pager}";

    /**
     * 头部按钮
     *
     * @var array
     */
    public $tools = [];

    public function init()
    {
        parent::init();
        $this->options['class'] = $this->panelClass;
        $this->summaryOptions['class'] = 'grid-summary'; // $this->panelTitleClass;
                                                         // $this->summaryOptions['tag'] = 'span';
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $this->tools[] = ob_get_clean() . Html::tag('div', parent::renderSummary(), [
            'class' => 'pull-right'
        ]);
        $this->_toolBody = Html::tag('div', implode(' ', $this->tools), [
            'class' => 'panel-tools'
        ]);
        return parent::run();
    }

    protected function renderPanelHeading()
    {
        $header = '';
        if ($this->intro) {
            if ($this->title) {
                $header .= Html::tag('div', $this->title, [
                    'class' => $this->panelTitleClass
                ]);
            }
            if (is_array($this->intro)) {
                $header .= implode('', array_map(function ($intro) {
                    return Html::tag('p', $intro);
                }, $this->intro));
            } else {
                $header .= Html::tag('p', $this->intro);
            }
        }
        return $header ? Html::tag('div', $header, [
            'class' => $this->panelHeadingClass
        ]) : '';
    }

    public function renderEmpty()
    {
        return Html::tag('div', parent::renderEmpty(), [
            'class' => $this->panelBodyClass
        ]);
    }

    public function renderItems()
    {
        return $this->renderPanelHeading() . Html::tag('div', $this->_toolBody . parent::renderItems(), [
            'class' => $this->panelBodyClass
        ]);
    }

    public function renderPager()
    {
        // return '';
        $pager = parent::renderPager();
        return empty($pager) ? '' : Html::tag('div', $pager, [
            'class' => 'panel-footer'
        ]);
    }
}
