<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AuthRule */

$this->title = '添加';
$this->params['breadcrumbs'][] = [
    'label' => '验证规则',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>