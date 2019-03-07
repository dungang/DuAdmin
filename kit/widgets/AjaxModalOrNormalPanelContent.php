<?php
namespace app\kit\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class AjaxModalOrNormalPanelContent extends Widget
{

    public $title = '';

    public $summary = '';

    public $content = '';

    public function run()
    {
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
            $header = Html::tag('h4', Html::encode($this->title), [
                'class' => 'modal-title'
            ]);
            return Html::tag('div', $btn . $header, [
                'class' => 'modal-header'
            ]);
        }
        return null;
    }

    protected function renderContent()
    {
        if (\Yii::$app->request->isAjax) {
            return Html::tag('div', $this->content, [
                'class' => 'modal-body'
            ]);
        } else {
            return Panel::widget([
                'title' => $this->summary,
                'content' => $this->content
            ]);
        }
    }
}

