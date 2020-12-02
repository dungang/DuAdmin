<?php
use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\AuthRule */

$this->title = '查看';
$this->params['breadcrumbs'][] = [
    'label' => '验证规则',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看验证规则信息：' . $model->name,
    'content' => DetailView::widget([
        'model' => $model,
        'attributes' => [
            'name',
            'data',
            'created_at',
            'updated_at'
        ]
    ])
])?>
