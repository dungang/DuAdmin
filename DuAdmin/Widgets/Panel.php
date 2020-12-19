<?php
namespace DuAdmin\Widgets;

use yii\base\Widget;
use yii\helpers\Html;

class Panel extends Widget
{
    /**
     * html attributes
     * @var array
     */
    public $options = ['class'=>'panel panel-info'];
    
    public $title;

    public $content;

    public $footer;
    
    public function run(){
        return Html::tag('div',$this->renderHeader().$this->renderContent().$this->renderFooter(),$this->options);
    }

    protected function renderHeader()
    {
        return $this->title? 
        '<div class="panel-heading"><div class="panel-title">' . Html::encode($this->title) . '</div></div>':'';
    }

    protected function renderContent()
    {
        return $this->content? '<div class="panel-body">'.$this->content.'</div>' :'';
    }

    protected function renderFooter()
    {
        return $this->footer? '<div class="panel-footer">'.$this->footer.'</div>':'';
    }
}

