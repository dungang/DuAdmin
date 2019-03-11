<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AcRoute */

$this->title = '更新';
$this->params['breadcrumbs'][] = [
    'label' => '路由',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->description,
    'url' => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑路由的基本信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
