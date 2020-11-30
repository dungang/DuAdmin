<?php
namespace app\mmadmin\grids;

use yii\helpers\Html;

class PanelTreeGridView extends TreeGrid
{

    public $title = '功能说明';

    /**
     * 说明
     *
     * @var string|array
     */
    public $intro;

    public $panelClass = 'panel panel-adminlte';

    public $panelHeadingClass = 'panel-heading clearfix';

    public $panelTitleClass = 'panel-title';

    public $panelBodyClass = 'panel-body';

    private $_body_content = '';

    /**
     *
     * {@inheritdoc}
     * @see \app\mmadmin\grids\GridView::init()
     */
    public function init()
    {
        parent::init();
        ob_start();
        ob_implicit_flush(false);
        $this->dataProvider->pagination = false;
    }

    public function run()
    {
        $this->_body_content = ob_get_clean();
        $panelHeading = $this->renderPanelHeading();
        $panelBody = Html::tag('div', $this->_body_content . parent::run(), [
            'class' => $this->panelBodyClass
        ]);
        return Html::tag('div', $panelHeading . $panelBody, [
            'class' => $this->panelClass
        ]);
    }

    protected function renderPanelHeading()
    {
        $header = '';
//         if ($this->intro) {
//             if ($this->title) {
//                 $header .= Html::tag('div', $this->title, ['class' => $this->panelTitleClass]);
//             }
//             if (is_array($this->intro)) {
//                 $header .= implode('', array_map(function ($intro) {
//                     return Html::tag('p', $intro);
//                 }, $this->intro));
//             } else {
//                 $header .= Html::tag('p', $this->intro);
//             }
//         }
        return $header ? Html::tag('div', $header, ['class' => $this->panelHeadingClass]) : '';
    }
}
