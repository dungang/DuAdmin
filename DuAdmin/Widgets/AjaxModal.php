<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * @author dungang<dungang@126.com>
 * 
 * 当ajax请求的时候只输出内容，
 */
class AjaxModal extends Widget
{

    private $content;

    public $template = '<div class="container">{content}</div>';

    public function run()
    {
        $content = ob_get_clean();
        $this->content = $content . $this->content;
        return $this->renderModalHeader() . $this->renderModalBody();
    }

    protected function renderModalHeader()
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

    protected function renderModalBody()
    {
        if (\Yii::$app->request->isAjax) {
            return Html::tag('div', $this->content, [
                'class' => 'modal-body'
            ]);
        } else {
            return str_replace("{content}",$this->content,$this->template);
        }
    }
}
