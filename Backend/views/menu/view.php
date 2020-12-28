<?php

use DuAdmin\Widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Menu */

$this->title = '查看';
$this->params['breadcrumbs'][] = ['label' => '菜单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：'  . $model->name,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'url:url',
            'isFront:boolean',
            'pid',
            'icon',
            'sort',
        ],
    ])
])?>