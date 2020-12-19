<?php
use Backend\Widgets\PortalWidget;
use DuAdmin\Widgets\AdminltePanel;
use DuAdmin\Widgets\TreeSortableList;
use yii\web\View;
/* @var $this View */
$this->title = '看板';
$this->params['breadcrumbs'][] = '看板';
?>
<?php // PortalWidget::widget() ?>
<?= AdminltePanel::widget([
    'content' => TreeSortableList::widget([
        'items' => [
            ['id'=>'1','title'=>'title1'],
            ['id'=>'2','title'=>'title1','children'=>[
                ['id'=>'5','title'=>'title5'],
                ['id'=>'6','title'=>'title6'],
            ]],
            ['id'=>'4','title'=>'title4'],
            ['id'=>'3','title'=>'title3'],
            ],
            'rowRender'=> function($item) {
                return $item['title'];
            }
    ])
])
?>