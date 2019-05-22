<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\forms\DynamicUser */

$this->title = '更新';
$this->params['breadcrumbs'][] = [
    'label' => '管理员',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->model->username,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro' => '编辑管理员的基本信息',
    'content' => $this->render('_form', [
        'model' => $model
    ])
])?>