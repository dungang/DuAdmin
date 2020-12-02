<?php

use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this \yii\web\View */
/* @var $models Backend\Models\AuthPermission[] */

$this->title = '批量更新';
$this->params['breadcrumbs'][] = ['label' => '权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'批量更新权限信息',
    'content'=>$this->render('_form-batch', ['models' => $models])
])
?>