<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\User */

$this->title = '更新用户' ;
$this->params['breadcrumbs'][] = [
    'label' => '用户',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->username,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = '更新';

echo AjaxModalOrNormalPanelContent::widget([
    'title'=>$this->title,
    'summary'=>$model->username,
    'content'=>$this->render('_form', ['model' => $model])
])?>