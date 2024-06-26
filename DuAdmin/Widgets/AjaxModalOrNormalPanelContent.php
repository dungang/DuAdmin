<?php

namespace DuAdmin\Widgets;

use yii\helpers\Html;

/**
 * @author dungang<dungang@126.com>
 * 
 * 当ajax请求的时候只输出内容，非ajax的输出panel的结构
 * 输出的内容会被modal包装
 * 如果不想被包装可以考虑使用父类 AdminltePanel
 */
class AjaxModalOrNormalPanelContent extends AdminltePanel
{

    public function run()
    {
        $content = ob_get_clean();
        $this->content = Html::tag('div', $content . $this->content, ['class' => 'panel-content']);
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

    protected function renderContent()
    {
        if (\Yii::$app->request->isAjax) {
            return Html::tag('div', $this->content, [
                'class' => 'modal-body'
            ]);
        } else {
            return parent::renderContent();
        }
    }
}
