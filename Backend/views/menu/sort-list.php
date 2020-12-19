<?php
use DuAdmin\Widgets\TreeSortableList;
use DuAdmin\Widgets\AdminltePanel;

/* @var $this yii\web\View */
/* @var $models DuAdmin\Models\Menu[] */

$this->title = '查看';
$this->params['breadcrumbs'][] = [
    'label' => '菜单',
    'url' => [
        'index'
    ]
];
echo AdminltePanel::widget([
    'intro' => '菜单排序管理',
    'content' => TreeSortableList::widget([
        'items' => $models,
        'rowRender' => function ($item) {
            return $item['name'];
        }
    ])
])?>