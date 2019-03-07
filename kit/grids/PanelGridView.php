<?php
namespace app\kit\grids;

use yii\helpers\Html;

/**
 * 对常规gridview的panel包装
 * @author dungang
 *
 */
class PanelGridView extends GridView
{

    public $panelClass = 'panel panel-adminlte';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body';

    private $_body_content = '';

   

    public function init()
    {
        parent::init();
        $this->options['class'] = $this->panelClass;
        $this->summaryOptions['class'] = $this->panelTitleClass;
        ob_start();
        ob_implicit_flush(false);
    }

    
    public function run(){
        $this->_body_content = ob_get_clean();
        return parent::run();
    }
    
  
    public function renderEmpty()
    {
        return Html::tag('div', parent::renderEmpty(), [
            'class' => $this->panelBodyClass
        ]);
    }

    public function renderItems()
    {
        return Html::tag('div', $this->_body_content . parent::renderItems(), [
            'class' => $this->panelBodyClass
        ]);
    }

    
    public function renderSummary()
    {
        $summary =  parent::renderSummary();
        return Html::tag('div', $summary? $summary:'无数据', [
            'class' => $this->panelHeadingClass
        ]);
    }
    

    public function renderPager()
    {
        $pagination = parent::renderPager();
        return empty($pagination)?$pagination: Html::tag('div',$pagination,['class'=>'panel-footer']);
    }
    
    
}

