<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model Backend\Models\AuthRole */

$this->title = '添加';
$this->params['breadcrumbs'][] = [
    'label' => '角色',
    'url' => [
        'index'
    ]
];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加角色的信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
