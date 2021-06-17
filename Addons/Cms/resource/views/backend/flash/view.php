<?php

use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Addons\Cms\Models\Flash */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => '轮播图片', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->name,
    'content' => DetailView::widget([
        'options' => ['class' => 'table table-bordered'],
        'model' => $model,
        'attributes' => [
            'name',
            'pic',
            'url:url',
            'sort',
            'createdAt:datetime',
            'updatedAt:datetime',
        ],
    ])
]);
