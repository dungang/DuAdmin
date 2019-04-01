<?php

use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Setting */

$this->title = '更新';
$this->params['breadcrumbs'][] = ['label' => \Yii::$app->controller->module->name . '设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;

echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑参数的基本信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
