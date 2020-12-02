<?php
use DuAdmin\Widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model DuAdmin\Models\Setting */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => \Yii::$app->controller->module->name . '设置', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加设置信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
