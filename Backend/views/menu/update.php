<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Menu */

$this->title = '更新';
$this->params['breadcrumbs'][] = [
    'label' => '菜单',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = [
    'label' => $model->name,
    'url' => [
        'view',
        'id' => $model->id
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'编辑菜单的基本信息',
    'content'=>$this->render('_form', ['model' => $model,'action'=>['update']])
])?>
