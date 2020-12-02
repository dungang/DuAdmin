<?php
use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthPermission */

$this->title = '查看';
$this->params['breadcrumbs'][] = [
    'label' => '权限',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $model->description;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看权限的信息：' . $model->description,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'type',
            'description:ntext',
            'rule_name',
            'data',
            'created_at',
            'updated_at'
        ]
    ])
])?>
