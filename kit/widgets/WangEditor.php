<?php
namespace app\kit\widgets;


use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use app\kit\assets\WangEditorAsset;

/**
 * wangeditor
 *
 * @author dungang
 *
 */
class WangEditor extends InputWidget
{
    
    public $clientOptions = [];
    
    public function run()
    {
        WangEditorAsset::register($this->view);
        $editor = $this->registerWangEditor();
        return $editor . $this->renderTextarea();
    }
    
    protected function renderTextarea()
    {
        $this->options['style'] = 'display:none;';
        if ($this->hasModel()) {
            return Html::activeTextarea($this->model, $this->attribute, $this->options);
        }
        return Html::textarea($this->name, $this->value, $this->options);
    }
    
    protected function registerWangEditor()
    {
        $request = \Yii::$app->getRequest();
        $id = $this->options['id'];
        $inputName = str_replace('-', '', $id);
        $editorId = 'editor-' . $id;
        $editorName = 'editor' . $inputName;
        if(empty($this->clientOptions['uploadImgParams'])){
            $this->clientOptions['uploadImgParams']=[];
        }
        $this->clientOptions['uploadImgParams'][$request->csrfParam] = $request->getCsrfToken();
        $this->clientOptions['uploadFileName']='file';
        $config = Json::encode((object) $this->clientOptions);
        $js = <<<JS
            var ${inputName} = $('#${id}');
            var ${editorName} = new window.wangEditor('#${editorId}');
            ${editorName}.customConfig = $config;
            ${editorName}.customConfig.onchange = function (html) {
                    ${inputName}.val(html)
                }
            ${editorName}.create();
            ${inputName}.val(${editorName}.txt.html());
JS;
            $this->view->registerJs($js);
            
            return Html::tag('div', Html::getAttributeValue($this->model, $this->attribute), [
                'id' => $editorId
            ]);
    }
}

