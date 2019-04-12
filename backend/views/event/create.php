<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Event */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '系统事件', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加系统事件信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
