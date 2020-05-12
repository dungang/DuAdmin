<?php

use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this \yii\web\View */
/* @var $models \app\mmadmin\models\AuthPermission[] */

$this->title = '批量更新';
$this->params['breadcrumbs'][] = ['label' => '权限', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'批量更新权限信息',
    'content'=>$this->render('_form-batch', ['models' => $models])
])
?>