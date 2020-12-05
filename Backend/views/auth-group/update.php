<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthGroup */

$this->title = '更新';
$this->params['breadcrumbs'][] = ['label' => '授权组', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>