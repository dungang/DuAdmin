<?php
use yii\widgets\DetailView;
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AcRoute */

$this->title = '查看';
$this->params['breadcrumbs'][] = [
    'label' => '路由',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $model->description;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看路由的信息：' . $model->description,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'description:ntext',
            'created_at:date',
            'updated_at:date'
        ]
    ])
])?>
