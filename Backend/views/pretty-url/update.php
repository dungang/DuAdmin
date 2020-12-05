<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Rewrite */

$this->title = '更新';
$this->params['breadcrumbs'][] = ['label' => 'URL重写', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>