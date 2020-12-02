<?php
namespace DuAdmin\Widgets;

use yii\bootstrap\InputWidget;
use DuAdmin\Assets\AutoCompleteAsset;
use yii\helpers\ArrayHelper;

/**
 * 搜索提示小部件
 * @author dungang<dungang@126.com>
 * @since date: 2019年10月15日
 * @link https://www.devbridge.com/sourcery/components/jquery-autocomplete/
 */
class AutoComplete extends InputWidget
{
    public function run(){
        AutoCompleteAsset::register($this->view);
        $this->options = ArrayHelper::merge( [
            'class'=>'form-control'
        ], $this->options);
        $this->registerPlugin("autocomplete");
        $this->view->registerCss($this->getStyles(),[],'autocomplete');
        return $this->renderInputHtml("text");
    }
    
    public function getStyles(){
        return <<<STYLE
.autocomplete-suggestions { border: 1px solid #999; background: #FFF; overflow: auto; }
.autocomplete-suggestion { padding: 2px 5px; white-space: nowrap; overflow: hidden; }
.autocomplete-selected { background: #F0F0F0; }
.autocomplete-suggestions strong { font-weight: normal; color: #3399FF; }
.autocomplete-group { padding: 2px 5px; }
.autocomplete-group strong { display: block; border-bottom: 1px solid #000; }
STYLE;
    }
} 



