<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\AppModule */

$this->title = '添加';
$this->params['breadcrumbs'][] = [
    'label' => '模块',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加模块的信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
