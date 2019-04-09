<?php
use app\kit\widgets\AjaxModalOrNormalPanelContent;

/* @var $this yii\web\View */
/* @var $model app\kit\models\Asset */

$this->title = '添加';
$this->params['breadcrumbs'][] = ['label' => '代码资源文件', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
echo AjaxModalOrNormalPanelContent::widget([
    'intro'=>'添加代码资源文件信息',
    'content'=>$this->render('_form', ['model' => $model])
])?>
