<?php
use app\mmadmin\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\mmadmin\models\User */

$this->title = '添加管理员';
$this->params['breadcrumbs'][] = [
    'label' => '管理员',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加管理员信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>