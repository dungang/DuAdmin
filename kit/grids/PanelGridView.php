<?php
namespace app\kit\grids;

use yii\helpers\Html;

/**
 * 对常规gridview的panel包装
 *
 * @author dungang
 *        
 */
class PanelGridView extends GridView
{

    /**
     * 面板标题
     * @var string
     */
    public $title = '功能说明';

    /**
     * 面板介绍
     * @var string|array
     */
    public $intro;

    public $panelClass = 'panel panel-adminlte';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body clearfix';

    private $_body_content = '';

    public $layout = "{items}\n{summary}";

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
        $this->_body_content = ob_get_clean() . Html::tag('div', parent::renderPager(), ['class' => 'pull-right']);
        if (!empty($this->_body_content)) {
            $this->_body_content = Html::tag('div', $this->_body_content, ['class' => 'panel-tools']);
        }
        return parent::run();
    }

    protected function renderPanelHeading()
    {
        $header = '';
        if ($this->intro) {
            if ($this->title) {
                $header .= Html::tag('div', $this->title, ['class' => $this->panelTitleClass]);
            }
            if (is_array($this->intro)) {
                $header .= implode('', array_map(function ($intro) {
                    return Html::tag('p', $intro);
                }, $this->intro));
            } else {
                $header .= Html::tag('p', $this->intro);
            }
        }
        return $header ? Html::tag('div', $header, ['class' => $this->panelHeadingClass]) : '';
    }

    public function renderEmpty()
    {
        return Html::tag('div', parent::renderEmpty(), [
            'class' => $this->panelBodyClass
        ]);
    }

    public function renderItems()
    {
        return $this->renderPanelHeading() . Html::tag('div', $this->_body_content . parent::renderItems(), [
            'class' => $this->panelBodyClass
        ]);
    }

    public function renderSummary()
    {
        // return '';
        $summary = parent::renderSummary();
        return empty($summary) ? '' : Html::tag('div', $summary, [
            'class' => 'panel-footer'
        ]);
    }
}
