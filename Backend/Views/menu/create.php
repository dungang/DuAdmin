<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Menu */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '菜单', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加菜单信息',
    'content'=>$this->render('_form', ['model' => $model,'action'=>['create']])
])?>