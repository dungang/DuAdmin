<?php
namespace app\kit\widgets;

use yii\helpers\Html;
use yii\base\Widget;
use app\kit\traits\AdminlitPanelTrait;

/**
 * 当ajax请求的时候只输出内容，非ajax的输出panel的结构
 */
class AjaxModalOrNormalPanelContent extends Widget
{

    use AdminlitPanelTrait;

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
