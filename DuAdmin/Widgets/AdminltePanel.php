<?php
namespace DuAdmin\Widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * 包装一个adminlte panel
 *
 * @author dungang
 *        
 */
class AdminltePanel extends Widget
{

    /**
     * 面板标题
     *
     * @var string
     */
    public $title = 'Function Description';

    /**
     * 说明
     *
     * @var string|array
     */
    public $intro = '';

    public $content = '';

    public $panelClass = 'panel panel-adminlte';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body clearfix';

    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $content = ob_get_clean();
        $this->content =  '<div class="panel-wrap">' .  $content . '</div>' . $this->content;
        return $this->renderContent();
    }

    protected function renderPanelHeading()
    {
        $header = '';
        if ($this->intro) {
            if ($this->title) {
                $header .= Html::tag('div', Yii::t('da', $this->title), [
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

    protected function renderBody()
    {
        return Html::tag('div', $this->content, [
            'class' => $this->panelBodyClass
        ]);
    }

    protected function renderContent()
    {
        return Html::tag('div', $this->renderPanelHeading() . $this->renderBody(), [
            'class' => $this->panelClass
        ]);
    }
}
