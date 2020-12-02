<?php
use yii\widgets\DetailView;
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\AuthRole */

$this->title = '查看';
$this->params['breadcrumbs'][] = [
    'label' => '角色',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $model->name;

echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '查看角色的信息：' . $model->name,
    'content' => DetailView::widget([
        'options'=>['class' => 'table table-bordered'],
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'scope',
            'description'
        ]
    ])
])?>
