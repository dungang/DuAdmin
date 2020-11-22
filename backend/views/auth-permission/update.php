<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\backend\models\AuthPermission */

$this->title = '更新';
$this->params['breadcrumbs'][] = [
    'label' => '权限',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->name
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑权限的基本信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
