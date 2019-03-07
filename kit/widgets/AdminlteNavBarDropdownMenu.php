<?php
namespace app\kit\widgets;

use yii\bootstrap\Widget;
use yii\bootstrap\Html;

/**
 * adminlte导航条的消息下拉按钮
 *
 * @author dungang
 *        
 */
abstract class AdminlteNavBarDropdownMenu extends Widget
{

    public $name = '消息';
    
    /**
     * 菜单主题样式类
     *
     * @var string
     */
    public $themeClass = 'messages-menu';

    /**
     * 通知数量
     *
     * @var integer
     */
    protected $counter = 0;
    
    public $counterUnit = '条';

    /**
     * 触发按钮的icon样式
     *
     * @var string
     */
    public $toggleButtonIconClass = 'fa fa-envelope-o';

    /**
     * 触发按钮的标签样式
     *
     * @var string
     */
    public $toggleButtonLabelClass = 'label label-success';
    
    public $footerUrl = '#';
    
    public $items = [];
    
    
    public function init(){
        parent::init();
        $this->counter = is_array($this->items)?count($this->items):0;
    }
    
    public function run(){
        $label = ($this->counter>0) ? Html::tag('span',$this->counter,['class'=>$this->toggleButtonLabelClass]):'';
        $btn = Html::a('<i class="'.$this->toggleButtonIconClass.'"></i> ' . $label,['class'=>'dropdown-toggle','data-toggle'=>'dropdown']);
        $menusBox =  Html::tag('li',$this->renderHeader() . $this->renderMenus() . $this->renderFooter(),['class'=>'dropdown-menu']);
        return Html::tag('li',$btn . $menusBox,['class'=>'dropdown ' . $this->themeClass]);
    }
    
    
    protected abstract function renderItem($item);
    
    
    
    protected function renderMenus(){
        if($this->counter > 0 ) {
            $items = '';
            foreach($this->items as $item) {
                $items .= Html::tag('li',$this->renderItem($item));
            }
            return Html::tag('li','<ul class="menu">'.$items . '</li>');
        }
        return '';
    }
    
    /**
     * 输出菜单头部
     * @return string
     */
    protected function renderHeader(){
        if($this->counter > 0 ) {
            return Html::tag('li','您有' . $this->counter . $this->counterUnit . $this->name,['class'=>'header']);
        }
        return '';
    }
    
    protected function renderFooter(){
        return Html::tag('li',Html::a('查看所有'.$this->name,[$this->footerUrl]),['class'=>'footer']);
    }
    
    

}

