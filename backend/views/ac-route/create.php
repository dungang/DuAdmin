<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AcRoute */

$this->title = '添加';
$this->params['breadcrumbs'][] = [
    'label' => '路由',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加路由的信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
