<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\User */

$this->title = '添加用户';
$this->params['breadcrumbs'][] = [
    'label' => '用户',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加用户信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>