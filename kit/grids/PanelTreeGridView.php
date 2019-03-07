<?php
namespace app\kit\grids;

use yii\helpers\Html;

class PanelTreeGridView extends TreeGrid
{

    public $panelTitle = '';

    public $panelClass = 'panel panel-adminlte';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body';

    private $_body_content = '';

    /**
     *
     * {@inheritdoc}
     * @see \app\kit\grids\GridView::init()
     */
    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
    }

    public function run()
    {
        $this->_body_content = ob_get_clean();
        $panelHeading = Html::tag('div', Html::tag('div', $this->panelTitle, [
            'class' => $this->panelTitleClass
        ]), [
            'class' => $this->panelHeadingClass
        ]);
        $panelBody = Html::tag('div', $this->_body_content . parent::run(), [
            'class' => $this->panelBodyClass
        ]);
        return Html::tag('div', $panelHeading . $panelBody, [
            'class' => $this->panelClass
        ]);
    }
}

