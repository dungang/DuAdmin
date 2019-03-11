<?php

use yii\widgets\DetailView;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Setting */

$this->title = '查看';
$this->params['breadcrumbs'][] = ['label' => '设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看信息：' . $model->name,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'title',
            'value:ntext',
        ],
    ])
])?>
