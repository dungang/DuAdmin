<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Menu */

$this->title = 'Update Menu: ' . $model->name;
$this->params['breadcrumbs'][] = [
    'label' => 'Menus',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = '更新';
echo AjaxModalOrNormalPanelContent::widget([
    'title' => $this->title,
    'summary' => $model->name,
    'content' => $this->render('_form', [
        'model' => $model
    ])
])?>
