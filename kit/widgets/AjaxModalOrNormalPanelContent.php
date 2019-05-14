<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * 当ajax请求的时候只输出内容，非ajax的输出panel的结构
 */
class AjaxModalOrNormalPanelContent extends Widget
{

    public $title = '功能说明';

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
        $this->content = $content . $this->content;
        return $this->renderHeader() . $this->renderContent();
    }

    protected function renderHeader()
    {
        if (\Yii::$app->request->isAjax) {

            $btn = Html::tag('button', '&times;', [
                'type' => 'button',
                'class' => 'close',
                'data-dismiss' => 'modal',
                'aria-hidden' => true
            ]);
            $header = Html::tag('h4', Html::encode($this->view->title), [
                'class' => 'modal-title'
            ]);
            return Html::tag('div', $btn . $header, [
                'class' => 'modal-header'
            ]);
        }
        return null;
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

    protected function renderBody()
    {
        return Html::tag('div', $this->content, ['class' => $this->panelBodyClass]);
    }

    protected function renderContent()
    {
        if (\Yii::$app->request->isAjax) {
            return Html::tag('div', $this->content, [
                'class' => 'modal-body'
            ]);
        } else {
            return Html::tag('div', $this->renderPanelHeading() . $this->renderBody(), ['class' => $this->panelClass]);
        }
    }
}
