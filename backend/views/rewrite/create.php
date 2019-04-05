<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Rewrite */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => 'Rewrites', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加URL重写信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
